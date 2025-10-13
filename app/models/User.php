<?php
// app/models/User.php (UPDATED)

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modified createUser to include full_name and staff_id
    public function createUser($username, $password, $role, $email, $fullName, $staffId) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password_hash, role, email, full_name, staff_id) VALUES (:username, :password_hash, :role, :email, :full_name, :staff_id)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password); // This should be the hashed password
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':staff_id', $staffId);
        return $stmt->execute();
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT user_id, username, role, email, full_name, staff_id FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // New method to get all users
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT user_id, username, role, email, full_name, staff_id, created_at FROM users ORDER BY username");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // New method to update user (for admin)
    public function updateUser($userId, $username, $role, $email, $fullName, $staffId, $password = null) {
        $sql = "UPDATE users SET username = :username, role = :role, email = :email, full_name = :full_name, staff_id = :staff_id";
        if ($password) {
            $sql .= ", password_hash = :password_hash";
        }
        $sql .= " WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':staff_id', $staffId);
        if ($password) {
            $stmt->bindParam(':password_hash', $password);
        }
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // New method to delete user
    public function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}