<?php
// app/controllers/OrderController.php

require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Supplier.php';

class OrderController {
    private $orderModel;
    private $productModel;
    private $supplierModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->supplierModel = new Supplier();
    }

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $orders = $this->orderModel->getAllOrders();
        $totalOrders = $this->orderModel->getTotalOrdersCount();
        $pendingOrders = $this->orderModel->getPendingOrdersCount();

        include __DIR__ . '/../views/orders/index.php';
    }

    public function create() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderData = [
                'supplier_id' => $_POST['supplier_id'],
                'order_date' => $_POST['order_date'],
                'expected_delivery_date' => $_POST['expected_delivery_date'],
                'status' => 'pending',
                'total_amount' => 0,
                'notes' => $_POST['notes'] ?? '',
                'created_by' => $_SESSION['user_id']
            ];

            $orderItems = [];
            $totalAmount = 0;

            // Process order items
            foreach ($_POST['items'] as $item) {
                if (!empty($item['product_id']) && !empty($item['quantity'])) {
                    // Get unit price from database
                    $product = $this->productModel->getProductById($item['product_id']);
                    if ($product) {
                        $unitPrice = $product['unit_price'];
                        $itemTotal = $item['quantity'] * $unitPrice;
                        $orderItems[] = [
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $unitPrice,
                            'total_price' => $itemTotal
                        ];
                        $totalAmount += $itemTotal;
                    }
                }
            }

            $orderData['total_amount'] = $totalAmount;

            // Validate that at least one item is added
            if (empty($orderItems)) {
                $_SESSION['error'] = "Please add at least one item to the order.";
            } else {
                try {
                    $orderId = $this->orderModel->createOrder($orderData, $orderItems);
                    $_SESSION['success'] = "Order created successfully! Order ID: " . $orderId;
                    header('Location: /wooden_design_ims/orders');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = "Error creating order: " . $e->getMessage();
                }
            }
        }

        $products = $this->productModel->getAllProducts();
        $suppliers = $this->supplierModel->getAllSuppliers();
        include __DIR__ . '/../views/orders/create.php';
    }

    public function edit($orderId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error'] = "Order not found!";
            header('Location: /wooden_design_ims/orders');
            exit();
        }

        // Prevent editing of delivered or cancelled orders
        if ($order['status'] == 'delivered' || $order['status'] == 'cancelled') {
            $_SESSION['error'] = "Cannot edit order with status: " . ucfirst($order['status']);
            header('Location: /wooden_design_ims/orders/show/' . $orderId);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderData = [
                'supplier_id' => $_POST['supplier_id'],
                'order_date' => $_POST['order_date'],
                'expected_delivery_date' => $_POST['expected_delivery_date'],
                'status' => $_POST['status'],
                'total_amount' => 0,
                'notes' => $_POST['notes'] ?? ''
            ];

            $orderItems = [];
            $totalAmount = 0;

            // Process order items
            foreach ($_POST['items'] as $item) {
                if (!empty($item['product_id']) && !empty($item['quantity']) && !empty($item['unit_price'])) {
                    $itemTotal = $item['quantity'] * $item['unit_price'];
                    $orderItems[] = [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $itemTotal
                    ];
                    $totalAmount += $itemTotal;
                }
            }

            $orderData['total_amount'] = $totalAmount;

            try {
                $this->orderModel->updateOrder($orderId, $orderData, $orderItems, $_SESSION['user_id']);
                
                // Add specific message for delivered status
                if ($orderData['status'] === 'delivered') {
                    $_SESSION['success'] = "Order updated to delivered and inventory increased successfully!";
                } else {
                    $_SESSION['success'] = "Order updated successfully!";
                }
                header('Location: /wooden_design_ims/orders');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = "Error updating order: " . $e->getMessage();
            }
        }

        $orderItems = $this->orderModel->getOrderItems($orderId);
        $products = $this->productModel->getAllProducts();
        $suppliers = $this->supplierModel->getAllSuppliers();
        include __DIR__ . '/../views/orders/edit.php';
    }

    public function show($orderId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error'] = "Order not found!";
            header('Location: /wooden_design_ims/orders');
            exit();
        }

        $orderItems = $this->orderModel->getOrderItems($orderId);
        include __DIR__ . '/../views/orders/show.php';
    }

    public function delete($orderId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        try {
            $this->orderModel->deleteOrder($orderId);
            $_SESSION['success'] = "Order deleted successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error deleting order: " . $e->getMessage();
        }

        header('Location: /wooden_design_ims/orders');
        exit();
    }

    public function receive($orderId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        try {
            $this->orderModel->receiveOrder($orderId, $_SESSION['user_id']);
            $_SESSION['success'] = "Order received and inventory updated successfully!";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error receiving order: " . $e->getMessage();
        }

        header('Location: /wooden_design_ims/orders');
        exit();
    }

    public function updateStatus($orderId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /wooden_design_ims/login');
            exit();
        }

        // Get current order to check status
        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            $_SESSION['error'] = "Order not found!";
            header('Location: /wooden_design_ims/orders');
            exit();
        }

        // Prevent status updates for delivered or cancelled orders
        if ($order['status'] == 'delivered' || $order['status'] == 'cancelled') {
            $_SESSION['error'] = "Cannot update status for order with status: " . ucfirst($order['status']);
            header('Location: /wooden_design_ims/orders/show/' . $orderId);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            try {
                $this->orderModel->updateOrderStatus($orderId, $status, $_SESSION['user_id']);
                
                // Add specific message for delivered status
                if ($status === 'delivered') {
                    $_SESSION['success'] = "Order status updated to delivered and inventory increased successfully!";
                } else {
                    $_SESSION['success'] = "Order status updated successfully!";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error updating order status: " . $e->getMessage();
            }
        }

        header('Location: /wooden_design_ims/orders/show/' . $orderId);
        exit();
    }
} 