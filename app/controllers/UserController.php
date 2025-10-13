<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        requireAdmin(); // Only Admin can manage users
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        $this->loadView('users/index', ['users' => $users]);
    }

    public function create() {
        $this->loadView('users/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullName = trim($_POST['full_name'] ?? '');
            $staffId = trim($_POST['staff_id'] ?? '');

            $errors = [];
            if (empty($username) || empty($password) || empty($confirmPassword) || empty($role) || empty($email) || empty($fullName) || empty($staffId)) {
                $errors[] = "All fields are required.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Passwords do not match.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters long.";
            }

            if (!empty($errors)) {
                $this->loadView('users/create', ['errors' => $errors, 'old_data' => $_POST]);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                if ($this->userModel->createUser($username, $hashedPassword, $role, $email, $fullName, $staffId)) {
                    $_SESSION['success_message'] = 'User account created successfully!';
                    header('Location: /wooden_design_ims/users');
                    exit();
                } else {
                    $this->loadView('users/create', ['error' => 'Failed to create user. Username or Staff ID might already exist.', 'old_data' => $_POST]);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $this->loadView('users/create', ['error' => 'Username or Staff ID already exists.', 'old_data' => $_POST]);
                } else {
                    $this->loadView('users/create', ['error' => 'Database error: ' . $e->getMessage(), 'old_data' => $_POST]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/users/create');
            exit();
        }
    }

    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header("HTTP/1.0 404 Not Found");
            echo "User not found.";
            exit();
        }
        $this->loadView('users/edit', ['user' => $user]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullName = trim($_POST['full_name'] ?? '');
            $staffId = trim($_POST['staff_id'] ?? '');
            $password = trim($_POST['password'] ?? ''); // Optional password change

            $errors = [];
            if (empty($username) || empty($role) || empty($email) || empty($fullName) || empty($staffId)) {
                $errors[] = "All required fields must be filled.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            if (!empty($password) && strlen($password) < 6) {
                $errors[] = "New password must be at least 6 characters long.";
            }

            if (!empty($errors)) {
                $user = $this->userModel->getUserById($id);
                $this->loadView('users/edit', ['user' => $user, 'errors' => $errors]);
                return;
            }

            $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

            try {
                if ($this->userModel->updateUser($id, $username, $role, $email, $fullName, $staffId, $hashedPassword)) {
                    $_SESSION['success_message'] = 'User account updated successfully!';
                    header('Location: /wooden_design_ims/users');
                    exit();
                } else {
                    $user = $this->userModel->getUserById($id);
                    $this->loadView('users/edit', ['user' => $user, 'error' => 'Failed to update user. Username or Staff ID might already exist.']);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $user = $this->userModel->getUserById($id);
                    $this->loadView('users/edit', ['user' => $user, 'error' => 'Username or Staff ID already exists.']);
                } else {
                    $user = $this->userModel->getUserById($id);
                    $this->loadView('users/edit', ['user' => $user, 'error' => 'Database error: ' . $e->getMessage()]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/users');
            exit();
        }
    }

    public function delete($id) {
        if ($id == $_SESSION['user_id']) { // Prevent admin from deleting themselves
            $_SESSION['error_message'] = 'You cannot delete your own account.';
            header('Location: /wooden_design_ims/users');
            exit();
        }

        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success_message'] = 'User deleted successfully.';
        } else {
            $_SESSION['error_message'] = 'Failed to delete user.';
        }
        header('Location: /wooden_design_ims/users');
        exit();
    }

    protected function loadView($viewName, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $viewName . '.php';
    }
}