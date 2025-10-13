<?php
// app/controllers/SupplierController.php

require_once __DIR__ . '/../models/Supplier.php';

class SupplierController {
    private $supplierModel;

    public function __construct() {
        requireAuth(); // Require authentication for all supplier actions
        $this->supplierModel = new Supplier();
    }

    /**
     * Displays a list of all suppliers.
     */
    public function index() {
        $suppliers = $this->supplierModel->getAllSuppliers();
        $this->loadView('suppliers/index', ['suppliers' => $suppliers]);
    }

    /**
     * Displays the form to create a new supplier.
     * Only accessible by Admin.
     */
    public function create() {
        requireAdmin(); // Only admin can create/edit/delete suppliers
        $this->loadView('suppliers/create');
    }

    /**
     * Stores a new supplier submitted via the create form.
     * Handles POST request. Only accessible by Admin.
     */
    public function store() {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $supplier_name = trim(isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '');
            $contact_person = trim(isset($_POST['contact_person']) ? $_POST['contact_person'] : '');
            $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
            $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
            $address = trim(isset($_POST['address']) ? $_POST['address'] : '');

            $errors = [];
            if (empty($supplier_name)) {
                $errors[] = "Supplier Name is required.";
            }
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            if (!empty($errors)) {
                $this->loadView('suppliers/create', ['errors' => $errors, 'old_data' => $_POST]);
                return;
            }

            try {
                if ($this->supplierModel->addSupplier($supplier_name, $contact_person, $phone, $email, $address)) {
                    $_SESSION['success_message'] = 'Supplier added successfully!';
                    header('Location: /wooden_design_ims/suppliers');
                    exit();
                } else {
                    $this->loadView('suppliers/create', ['error' => 'Failed to add supplier.', 'old_data' => $_POST]);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $this->loadView('suppliers/create', ['error' => 'A supplier with this name already exists.', 'old_data' => $_POST]);
                } else {
                    $this->loadView('suppliers/create', ['error' => 'Database error: ' . htmlspecialchars($e->getMessage()), 'old_data' => $_POST]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/suppliers/create');
            exit();
        }
    }

    /**
     * Displays the form to edit an existing supplier.
     * @param int $id The ID of the supplier to edit. Only accessible by Admin.
     */
    public function edit($id) {
        requireAdmin();
        $supplier = $this->supplierModel->getSupplierById($id);
        if (!$supplier) {
            header("HTTP/1.0 404 Not Found");
            echo "Supplier not found.";
            exit();
        }
        $this->loadView('suppliers/edit', ['supplier' => $supplier]);
    }

    /**
     * Updates an existing supplier submitted via the edit form.
     * Handles POST request. Only accessible by Admin.
     * @param int $id The ID of the supplier to update.
     */
    public function update($id) {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $supplier_name = trim(isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '');
            $contact_person = trim(isset($_POST['contact_person']) ? $_POST['contact_person'] : '');
            $phone = trim(isset($_POST['phone']) ? $_POST['phone'] : '');
            $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
            $address = trim(isset($_POST['address']) ? $_POST['address'] : '');

            $errors = [];
            if (empty($supplier_name)) {
                $errors[] = "Supplier Name is required.";
            }
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            if (!empty($errors)) {
                $supplier = $this->supplierModel->getSupplierById($id); // Re-fetch for error display
                $this->loadView('suppliers/edit', ['supplier' => $supplier, 'errors' => $errors]);
                return;
            }

            try {
                if ($this->supplierModel->updateSupplier($id, $supplier_name, $contact_person, $phone, $email, $address)) {
                    $_SESSION['success_message'] = 'Supplier updated successfully!';
                    header('Location: /wooden_design_ims/suppliers');
                    exit();
                } else {
                    $supplier = $this->supplierModel->getSupplierById($id); // Re-fetch for error display
                    $this->loadView('suppliers/edit', ['supplier' => $supplier, 'error' => 'Failed to update supplier.']);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $supplier = $this->supplierModel->getSupplierById($id);
                    $this->loadView('suppliers/edit', ['supplier' => $supplier, 'error' => 'A supplier with this name already exists.']);
                } else {
                    $supplier = $this->supplierModel->getSupplierById($id);
                    $this->loadView('suppliers/edit', ['supplier' => $supplier, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/suppliers');
            exit();
        }
    }

    /**
     * Deletes a supplier. Only accessible by Admin.
     * @param int $id The ID of the supplier to delete.
     */
    public function delete($id) {
        requireAdmin();
        try {
            if ($this->supplierModel->deleteSupplier($id)) {
                $_SESSION['success_message'] = 'Supplier deleted successfully.';
            } else {
                $_SESSION['error_message'] = 'Failed to delete supplier.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                $_SESSION['error_message'] = 'Cannot delete supplier: Transactions are linked to this supplier. Please remove linked transactions first.';
            } else {
                $_SESSION['error_message'] = 'Database error: ' . htmlspecialchars($e->getMessage());
            }
        }
        header('Location: /wooden_design_ims/suppliers');
        exit();
    }

    /**
     * Helper method to load a view file.
     *
     * @param string $viewName The name of the view file (e.g., 'suppliers/index').
     * @param array $data An associative array of data to pass to the view.
     */
    protected function loadView($viewName, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $viewName . '.php';
    }
}