<?php
// app/models/InventoryLog.php

class InventoryLog {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addLog($productId, $userId, $actionType, $quantityChange = null, $previousStock = null, $newStock = null, $reason = '', $referenceNumber = '') {
        $stmt = $this->db->prepare("
            INSERT INTO inventory_logs (product_id, user_id, action_type, quantity_change, previous_stock, new_stock, reason, reference_number)
            VALUES (:product_id, :user_id, :action_type, :quantity_change, :previous_stock, :new_stock, :reason, :reference_number)
        ");
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':action_type', $actionType);
        $stmt->bindParam(':quantity_change', $quantityChange, PDO::PARAM_INT);
        $stmt->bindParam(':previous_stock', $previousStock, PDO::PARAM_INT);
        $stmt->bindParam(':new_stock', $newStock, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':reference_number', $referenceNumber);
        return $stmt->execute();
    }

    public function getLogsByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT il.*, u.full_name as user_name, p.product_name, p.product_code
            FROM inventory_logs il
            JOIN users u ON il.user_id = u.user_id
            JOIN products p ON il.product_id = p.product_id
            WHERE il.product_id = :productId
            ORDER BY il.created_at DESC
        ");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllLogs() {
        $stmt = $this->db->query("
            SELECT il.*, u.full_name as user_name, p.product_name, p.product_code
            FROM inventory_logs il
            JOIN users u ON il.user_id = u.user_id
            JOIN products p ON il.product_id = p.product_id
            ORDER BY il.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
