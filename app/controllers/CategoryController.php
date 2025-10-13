<?php
// app/controllers/CategoryController.php

require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        requireAuth(); // Require authentication for all category actions
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $this->loadView('categories/index', ['categories' => $categories]);
    }

    public function create() {
        requireAdmin(); // Only admin can create/edit/delete categories
        $this->loadView('categories/create');
    }

    public function store() {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['category_name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                // Handle error: Name is required
                $this->loadView('categories/create', ['error' => 'Category name is required.']);
                return;
            }

            if ($this->categoryModel->addCategory($name, $description)) {
                header('Location: /wooden_design_ims/categories');
                exit();
            } else {
                $this->loadView('categories/create', ['error' => 'Failed to add category. It might already exist.']);
            }
        } else {
            header('Location: /wooden_design_ims/categories/create');
            exit();
        }
    }

    public function edit($id) {
        requireAdmin();
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            echo "Category not found.";
            exit();
        }
        $this->loadView('categories/edit', ['category' => $category]);
    }

    public function update($id) {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['category_name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                $category = $this->categoryModel->getCategoryById($id);
                $this->loadView('categories/edit', ['category' => $category, 'error' => 'Category name is required.']);
                return;
            }

            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /wooden_design_ims/categories');
                exit();
            } else {
                $category = $this->categoryModel->getCategoryById($id);
                $this->loadView('categories/edit', ['category' => $category, 'error' => 'Failed to update category.']);
            }
        } else {
            header('Location: /wooden_design_ims/categories');
            exit();
        }
    }

    public function delete($id) {
        requireAdmin();
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success_message'] = 'Category deleted successfully.';
        } else {
            $_SESSION['error_message'] = 'Failed to delete category. Ensure no products are linked to it.';
        }
        header('Location: /wooden_design_ims/categories');
        exit();
    }

    protected function loadView($viewName, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $viewName . '.php';
    }
}