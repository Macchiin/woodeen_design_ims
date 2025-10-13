<?php
// app/controllers/ProductController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Brand.php';
require_once __DIR__ . '/../models/Supplier.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $brandModel;
    private $supplierModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->brandModel = new Brand();
        $this->supplierModel = new Supplier();
    }

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }` 

        $products = $this->productModel->getAllProducts();
        $totalProducts = $this->productModel->getTotalProductsCount();
        $lowStockCount = $this->productModel->getLowStockCount();
        
        include __DIR__ . '/../views/products/index.php';
    }

    public function create() {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => trim($_POST['product_name']),
                'product_code' => trim($_POST['product_code']),
                'description' => trim($_POST['description']),
                'category_id' => (int)$_POST['category_id'],
                'brand_id' => (int)$_POST['brand_id'],
                'supplier_id' => (int)$_POST['supplier_id'],
                'current_stock' => (int)$_POST['current_stock'],
                'unit_price' => (float)$_POST['unit_price'],
                'reorder_level' => (int)$_POST['reorder_level']
            ];

            // Validation
            if (empty($data['product_name']) || empty($data['product_code']) || 
                $data['category_id'] == 0 || $data['brand_id'] == 0 || $data['supplier_id'] == 0) {
                $_SESSION['error'] = 'Please fill all required fields correctly.';
            } else {
                try {
                    if ($this->productModel->addProduct($data)) {
                        $_SESSION['success'] = 'Product added successfully!';
                        header('Location: /wooden_design_ims/products');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Failed to add product.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Error: ' . $e->getMessage();
                }
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $brands = $this->brandModel->getAllBrands();
        $suppliers = $this->supplierModel->getAllSuppliers();
        include __DIR__ . '/../views/products/create.php';
    }

    public function edit($id) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found!';
            header('Location: /wooden_design_ims/products');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'product_name' => trim($_POST['product_name']),
                'product_code' => trim($_POST['product_code']),
                'description' => trim($_POST['description']),
                'category_id' => (int)$_POST['category_id'],
                'brand_id' => (int)$_POST['brand_id'],
                'supplier_id' => (int)$_POST['supplier_id'],
                'current_stock' => (int)$_POST['current_stock'],
                'unit_price' => (float)$_POST['unit_price'],
                'reorder_level' => (int)$_POST['reorder_level']
            ];

            // Validation
            if (empty($data['product_name']) || empty($data['product_code']) || 
                $data['category_id'] == 0 || $data['brand_id'] == 0 || $data['supplier_id'] == 0) {
                $_SESSION['error'] = 'Please fill all required fields correctly.';
            } else {
                try {
                    if ($this->productModel->updateProduct($id, $data)) {
                        $_SESSION['success'] = 'Product updated successfully!';
                        header('Location: /wooden_design_ims/products');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Failed to update product.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Error: ' . $e->getMessage();
                }
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $brands = $this->brandModel->getAllBrands();
        $suppliers = $this->supplierModel->getAllSuppliers();
        include __DIR__ . '/../views/products/edit.php';
    }

    public function delete($id) {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        try {
            if ($this->productModel->deleteProduct($id)) {
                $_SESSION['success'] = 'Product deleted successfully!';
            } else {
                $_SESSION['error'] = 'Failed to delete product.';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        header('Location: /wooden_design_ims/products');
        exit();
    }

    public function updateStock($id) {
        // Check if user is logged in (staff can update inventory)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found!';
            header('Location: /wooden_design_ims/products');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantityChange = (int)$_POST['quantity_change'];
            $actionType = $_POST['action_type'];
            $reason = trim($_POST['reason']);
            $referenceNumber = trim($_POST['reference_number']);

            if ($quantityChange == 0) {
                $_SESSION['error'] = 'Quantity change cannot be zero.';
            } else {
                try {
                    if ($this->productModel->updateStock($id, $quantityChange, $_SESSION['user_id'], $actionType, $reason, $referenceNumber)) {
                        $_SESSION['success'] = 'Inventory updated successfully!';
                        header('Location: /wooden_design_ims/products');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Failed to update inventory.';
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = 'Error: ' . $e->getMessage();
                }
            }
        }

        include __DIR__ . '/../views/products/update_stock.php';
    }

    public function lowStock() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $lowStockProducts = $this->productModel->getLowStockProducts();
        $lowStockCount = $this->productModel->getLowStockCount();
        
        include __DIR__ . '/../views/products/low_stock.php';
    }

    public function inventoryLogs($productId = null) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $logs = $this->productModel->getInventoryLogs($productId);
        $product = null;
        if ($productId) {
            $product = $this->productModel->getProductById($productId);
        }
        
        include __DIR__ . '/../views/products/inventory_logs.php';
    }

    public function search() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $searchTerm = $_GET['q'] ?? '';
        $products = [];
        
        if (!empty($searchTerm)) {
            $products = $this->productModel->searchProducts($searchTerm);
        }
        
        include __DIR__ . '/../views/products/search.php';
    }
}
