<?php
// app/controllers/BrandController.php

require_once __DIR__ . '/../models/Brand.php';

class BrandController {
    private $brandModel;

    public function __construct() {
        requireAuth(); // Require authentication for all brand actions
        $this->brandModel = new Brand();
    }

    /**
     * Displays a list of all brands.
     */
    public function index() {
        $brands = $this->brandModel->getAllBrands();
        $this->loadView('brands/index', ['brands' => $brands]);
    }

    /**
     * Displays the form to create a new brand.
     * Only accessible by Admin.
     */
    public function create() {
        requireAdmin(); // Only admin can create/edit/delete brands
        $this->loadView('brands/create');
    }

    /**
     * Stores a new brand submitted via the create form.
     * Handles POST request. Only accessible by Admin.
     */
    public function store() {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim(isset($_POST['brand_name']) ? $_POST['brand_name'] : '');
            $description = trim(isset($_POST['description']) ? $_POST['description'] : '');

            if (empty($name)) {
                $this->loadView('brands/create', ['error' => 'Brand name is required.', 'old_data' => $_POST]);
                return;
            }

            try {
                if ($this->brandModel->addBrand($name, $description)) {
                    $_SESSION['success_message'] = 'Brand added successfully!';
                    header('Location: /wooden_design_ims/brands');
                    exit();
                } else {
                    $this->loadView('brands/create', ['error' => 'Failed to add brand.', 'old_data' => $_POST]);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $this->loadView('brands/create', ['error' => 'A brand with this name already exists.', 'old_data' => $_POST]);
                } else {
                    $this->loadView('brands/create', ['error' => 'Database error: ' . htmlspecialchars($e->getMessage()), 'old_data' => $_POST]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/brands/create');
            exit();
        }
    }

    /**
     * Displays the form to edit an existing brand.
     * @param int $id The ID of the brand to edit. Only accessible by Admin.
     */
    public function edit($id) {
        requireAdmin();
        $brand = $this->brandModel->getBrandById($id);
        if (!$brand) {
            header("HTTP/1.0 404 Not Found");
            echo "Brand not found.";
            exit();
        }
        $this->loadView('brands/edit', ['brand' => $brand]);
    }

    /**
     * Updates an existing brand submitted via the edit form.
     * Handles POST request. Only accessible by Admin.
     * @param int $id The ID of the brand to update.
     */
    public function update($id) {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim(isset($_POST['brand_name']) ? $_POST['brand_name'] : '');
            $description = trim(isset($_POST['description']) ? $_POST['description'] : '');

            if (empty($name)) {
                $brand = $this->brandModel->getBrandById($id); // Re-fetch for error display
                $this->loadView('brands/edit', ['brand' => $brand, 'error' => 'Brand name is required.']);
                return;
            }

            try {
                if ($this->brandModel->updateBrand($id, $name, $description)) {
                    $_SESSION['success_message'] = 'Brand updated successfully!';
                    header('Location: /wooden_design_ims/brands');
                    exit();
                } else {
                    $brand = $this->brandModel->getBrandById($id); // Re-fetch for error display
                    $this->loadView('brands/edit', ['brand' => $brand, 'error' => 'Failed to update brand.']);
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Duplicate entry error code
                    $brand = $this->brandModel->getBrandById($id);
                    $this->loadView('brands/edit', ['brand' => $brand, 'error' => 'A brand with this name already exists.']);
                } else {
                    $brand = $this->brandModel->getBrandById($id);
                    $this->loadView('brands/edit', ['brand' => $brand, 'error' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
                }
            }
        } else {
            header('Location: /wooden_design_ims/brands');
            exit();
        }
    }

    /**
     * Deletes a brand. Only accessible by Admin.
     * @param int $id The ID of the brand to delete.
     */
    public function delete($id) {
        requireAdmin();
        try {
            if ($this->brandModel->deleteBrand($id)) {
                $_SESSION['success_message'] = 'Brand deleted successfully.';
            } else {
                $_SESSION['error_message'] = 'Failed to delete brand. Ensure no products are linked to it.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                $_SESSION['error_message'] = 'Cannot delete brand: Products are linked to it. Please reassign products first.';
            } else {
                $_SESSION['error_message'] = 'Database error: ' . htmlspecialchars($e->getMessage());
            }
        }
        header('Location: /wooden_design_ims/brands');
        exit();
    }

    /**
     * Helper method to load a view file.
     *
     * @param string $viewName The name of the view file (e.g., 'brands/index').
     * @param array $data An associative array of data to pass to the view.
     */
    protected function loadView($viewName, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $viewName . '.php';
    }
}