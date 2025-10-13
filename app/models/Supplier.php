<?php
// app/models/Supplier.php

class Supplier {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all suppliers from the database.
     * @return array An array of supplier records.
     */
    public function getAllSuppliers() {
        $stmt = $this->db->query("SELECT * FROM suppliers ORDER BY supplier_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single supplier by its ID.
     * @param int $id The ID of the supplier.
     * @return array|false An associative array of the supplier record, or false if not found.
     */
    public function getSupplierById($id) {
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE supplier_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new supplier to the database.
     * @param string $supplier_name The name of the supplier.
     * @param string|null $contact_person Contact person's name.
     * @param string|null $phone Phone number.
     * @param string|null $email Email address.
     * @param string|null $address Physical address.
     * @return bool True on success, false on failure.
     */
    public function addSupplier($supplier_name, $contact_person = null, $phone = null, $email = null, $address = null) {
        $stmt = $this->db->prepare("INSERT INTO suppliers (supplier_name, contact_person, phone, email, address) VALUES (:supplier_name, :contact_person, :phone, :email, :address)");
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':contact_person', $contact_person);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        return $stmt->execute();
    }

    /**
     * Update an existing supplier in the database.
     * @param int $id The ID of the supplier to update.
     * @param string $supplier_name The new name of the supplier.
     * @param string|null $contact_person New contact person's name.
     * @param string|null $phone New phone number.
     * @param string|null $email New email address.
     * @param string|null $address New physical address.
     * @return bool True on success, false on failure.
     */
    public function updateSupplier($id, $supplier_name, $contact_person = null, $phone = null, $email = null, $address = null) {
        $stmt = $this->db->prepare("UPDATE suppliers SET supplier_name = :supplier_name, contact_person = :contact_person, phone = :phone, email = :email, address = :address WHERE supplier_id = :id");
        $stmt->bindParam(':supplier_name', $supplier_name);
        $stmt->bindParam(':contact_person', $contact_person);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Delete a supplier from the database.
     * Note: Due to FOREIGN KEY constraints (ON DELETE RESTRICT), this will fail
     * if there are transactions linked to this supplier.
     * @param int $id The ID of the supplier to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteSupplier($id) {
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE supplier_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}