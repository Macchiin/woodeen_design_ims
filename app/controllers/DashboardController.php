<?php
// app/controllers/DashboardController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';

class DashboardController {
    private $productModel;
    private $orderModel;
    private $userModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userModel = new User();
    }

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        // Get dashboard statistics
        $totalProducts = $this->productModel->getTotalProductsCount();
        $lowStockCount = $this->productModel->getLowStockCount();
        $totalOrders = $this->orderModel->getTotalOrdersCount();
        $pendingOrders = $this->orderModel->getPendingOrdersCount();
        
        // Get low stock products for alerts
        $lowStockProducts = $this->productModel->getLowStockProducts();
        
        // Debug: Check if we're getting data
        error_log("Dashboard - Low Stock Products Count: " . count($lowStockProducts));
        if (!empty($lowStockProducts)) {
            error_log("Dashboard - First Product: " . print_r($lowStockProducts[0], true));
        }
        
        // Get recent inventory logs
        $recentLogs = $this->productModel->getInventoryLogs(null, 10);
        
        // Get recent orders
        $recentOrders = $this->orderModel->getOrdersByStatus('pending');
        
        include __DIR__ . '/../views/dashboard/index.php';
    }
}
