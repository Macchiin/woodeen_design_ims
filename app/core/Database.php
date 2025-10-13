<?php
// app/core/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Load database configuration
        require_once __DIR__ . '/../config/database.php';

        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch rows as associative arrays
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation for better security and performance
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Log error (for production) and display a user-friendly message (for development)
            error_log("Database connection failed: " . $e->getMessage()); // Log to PHP error log
            die("Sorry, we're experiencing technical difficulties. Please try again later. (Error: DB_CONN_FAILED)");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}