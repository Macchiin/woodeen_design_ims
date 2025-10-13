<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // Handle POST request for login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = "Please enter both username and password.";
                $this->loadView('auth/login', ['error' => $error]);
                return;
            }

            $user = $this->userModel->findByUsername($username);

            if ($user && $this->userModel->verifyPassword($password, $user['password_hash'])) {
                // Login successful
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect to dashboard or appropriate page
                header('Location: /wooden_design_ims/dashboard'); // Adjust path if needed
                exit();
            } else {
                $error = "Invalid username or password.";
                $this->loadView('auth/login', ['error' => $error]);
            }
        } else {
            // Display login form
            $this->loadView('auth/login');
        }
    }

    public function logout() {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: /wooden_design_ims/login'); // Redirect to login page
        exit();
    }

    // Helper to load views
    protected function loadView($viewName, $data = []) {
        // Extract data to make it available in the view
        extract($data);
        require_once __DIR__ . '/../views/' . $viewName . '.php';
    }
}