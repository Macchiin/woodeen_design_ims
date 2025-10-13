<?php
// app/models/Brand.php

class Brand {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all brands from the database.
     * @return array An array of brand records.
     */
    public function getAllBrands() {
        $stmt = $this->db->query("SELECT * FROM brands ORDER BY brand_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single brand by its ID.
     * @param int $id The ID of the brand.
     * @return array|false An associative array of the brand record, or false if not found.
     */
    public function getBrandById($id) {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE brand_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new brand to the database.
     * @param string $name The name of the brand.
     * @param string|null $description The description of the brand (optional).
     * @return bool True on success, false on failure.
     */
    public function addBrand($name, $description = null) {
        $stmt = $this->db->prepare("INSERT INTO brands (brand_name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    /**
     * Update an existing brand in the database.
     * @param int $id The ID of the brand to update.
     * @param string $name The new name of the brand.
     * @param string|null $description The new description of the brand (optional).
     * @return bool True on success, false on failure.
     */
    public function updateBrand($id, $name, $description = null) {
        $stmt = $this->db->prepare("UPDATE brands SET brand_name = :name, description = :description WHERE brand_id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Delete a brand from the database.
     * Note: Due to FOREIGN KEY constraints (ON DELETE RESTRICT), this will fail
     * if there are products linked to this brand.
     * @param int $id The ID of the brand to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteBrand($id) {
        $stmt = $this->db->prepare("DELETE FROM brands WHERE brand_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}