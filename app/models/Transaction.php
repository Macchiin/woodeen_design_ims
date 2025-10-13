<?php
// app/models/Transaction.php

class Transaction {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Returns the PDO database connection instance.
     * @return PDO The PDO database connection object.
     */
    public function getConnection() {
        return $this->db;
    }

    /**
     * Creates a new transaction record.
     *
     * @param string $type Type of transaction ('purchase' or 'sale').
     * @param int $userId The ID of the user performing the transaction.
     * @param float $totalAmount The total amount of the transaction.
     * @param int|null $supplierId The ID of the supplier (for purchases), null for sales.
     * @param string|null $notes Any additional notes for the transaction.
     * @param string|null $receiptPath Path to the uploaded receipt file.
     * @param string|null $expectedDeliveryDate Expected delivery date for purchases (YYYY-MM-DD).
     * @param string|null $purchaseReference Reference number for purchases.
     * @return int The ID of the newly created transaction, or false on failure.
     */
    public function createTransaction($type, $userId, $totalAmount, $supplierId = null, $notes = null, $receiptPath = null, $expectedDeliveryDate = null, $purchaseReference = null) {
        $stmt = $this->db->prepare("
            INSERT INTO transactions (transaction_type, user_id, total_amount, supplier_id, notes, receipt_path, expected_delivery_date, purchase_reference)
            VALUES (:type, :userId, :totalAmount, :supplierId, :notes, :receiptPath, :expectedDeliveryDate, :purchaseReference)
        ");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':totalAmount', $totalAmount);
        $stmt->bindParam(':supplierId', $supplierId, PDO::PARAM_INT);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':receiptPath', $receiptPath);
        $stmt->bindParam(':expectedDeliveryDate', $expectedDeliveryDate);
        $stmt->bindParam(':purchaseReference', $purchaseReference);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Retrieves all transactions with associated user and supplier names.
     *
     * @return array An array of transaction records.
     */
    public function getAllTransactions() {
        $stmt = $this->db->query("
            SELECT t.*, u.username, s.supplier_name
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
            ORDER BY t.transaction_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves detailed information for a specific transaction, including its items.
     *
     * @param int $transactionId The ID of the transaction.
     * @return array An array of transaction items, each including main transaction details.
     */
    public function getTransactionDetails($transactionId) {
        $stmt = $this->db->prepare("
            SELECT t.*, u.username, s.supplier_name,
                   ti.quantity, ti.unit_price_at_transaction, ti.subtotal AS item_subtotal,
                   p.product_name, p.sku
            FROM transactions t
            JOIN users u ON t.user_id = u.user_id
            LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
            JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
            JOIN products p ON ti.product_id = p.product_id
            WHERE t.transaction_id = :transactionId
            ORDER BY p.product_name
        ");
        $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}