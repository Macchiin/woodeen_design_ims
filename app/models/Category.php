<?php
// app/models/Category.php

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY category_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE category_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCategory($name, $description = null) {
        $stmt = $this->db->prepare("INSERT INTO categories (category_name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function updateCategory($id, $name, $description = null) {
        $stmt = $this->db->prepare("UPDATE categories SET category_name = :name, description = :description WHERE category_id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        // Check for related products before deleting (handled by FK 'RESTRICT')
        $stmt = $this->db->prepare("DELETE FROM categories WHERE category_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}