<?php
// app/models/TransactionItem.php

class TransactionItem {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addTransactionItem($transactionId, $productId, $quantity, $unitPrice, $subtotal) {
        $stmt = $this->db->prepare("INSERT INTO transaction_items (transaction_id, product_id, quantity, unit_price_at_transaction, subtotal) VALUES (:transaction_id, :product_id, :quantity, :unit_price, :subtotal)");
        $stmt->bindParam(':transaction_id', $transactionId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':unit_price', $unitPrice);
        $stmt->bindParam(':subtotal', $subtotal);
        return $stmt->execute();
    }
}