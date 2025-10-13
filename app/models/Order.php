<?php
// app/models/Order.php

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllOrders() {
        $stmt = $this->db->query("
            SELECT o.*, s.supplier_name, s.contact_person, u.full_name as created_by_name
            FROM orders o
            JOIN suppliers s ON o.supplier_id = s.supplier_id
            JOIN users u ON o.created_by = u.user_id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderId) {
        $stmt = $this->db->prepare("
            SELECT o.*, s.supplier_name, s.contact_person, s.email, s.phone, u.full_name as created_by_name
            FROM orders o
            JOIN suppliers s ON o.supplier_id = s.supplier_id
            JOIN users u ON o.created_by = u.user_id
            WHERE o.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.product_name, p.product_code, p.unit_price as current_price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id
        ");
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder($orderData, $orderItems) {
        $this->db->beginTransaction();
        
        try {
            // Generate order number
            $orderData['order_number'] = $this->generateOrderNumber();
            
            // Insert order
            $stmt = $this->db->prepare("
                INSERT INTO orders (order_number, supplier_id, order_date, expected_delivery_date, status, total_amount, notes, created_by)
                VALUES (:order_number, :supplier_id, :order_date, :expected_delivery_date, :status, :total_amount, :notes, :created_by)
            ");
            $stmt->execute($orderData);
            
            $orderId = $this->db->lastInsertId();
            
            // Insert order items
            foreach ($orderItems as $item) {
                $item['order_id'] = $orderId;
                $stmt = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price)
                    VALUES (:order_id, :product_id, :quantity, :unit_price, :total_price)
                ");
                $stmt->execute($item);
            }
            
            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateOrder($orderId, $orderData, $orderItems = null, $userId = null) {
        $this->db->beginTransaction();
        
        try {
            // Get current order status before update
            $currentOrder = $this->getOrderById($orderId);
            $currentStatus = $currentOrder['status'];
            $newStatus = $orderData['status'];
            
            // Update order
            $stmt = $this->db->prepare("
                UPDATE orders 
                SET supplier_id = :supplier_id, order_date = :order_date, 
                    expected_delivery_date = :expected_delivery_date, status = :status, 
                    total_amount = :total_amount, notes = :notes
                WHERE order_id = :order_id
            ");
            $orderData['order_id'] = $orderId;
            $stmt->execute($orderData);
            
            // Update order items if provided
            if ($orderItems !== null) {
                // Delete existing items
                $stmt = $this->db->prepare("DELETE FROM order_items WHERE order_id = :order_id");
                $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->execute();
                
                // Insert new items
                foreach ($orderItems as $item) {
                    $item['order_id'] = $orderId;
                    $stmt = $this->db->prepare("
                        INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price)
                        VALUES (:order_id, :product_id, :quantity, :unit_price, :total_price)
                    ");
                    $stmt->execute($item);
                }
            }
            
            // If status is being changed to 'delivered' and it wasn't delivered before
            if ($newStatus === 'delivered' && $currentStatus !== 'delivered' && $userId) {
                // Get order items (use new items if provided, otherwise get existing)
                $itemsToUpdate = $orderItems !== null ? $orderItems : $this->getOrderItems($orderId);
                
                // Update stock for each item
                $productModel = new Product();
                foreach ($itemsToUpdate as $item) {
                    $productModel->updateStock(
                        $item['product_id'], 
                        $item['quantity'], 
                        $userId, 
                        'in', 
                        'Order delivered: ' . $orderId,
                        $orderId
                    );
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function updateOrderStatus($orderId, $status, $userId = null) {
        $this->db->beginTransaction();
        
        try {
            // Get current order status
            $currentOrder = $this->getOrderById($orderId);
            $currentStatus = $currentOrder['status'];
            
            // Update order status
            $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            // If status is being changed to 'delivered' and it wasn't delivered before
            if ($status === 'delivered' && $currentStatus !== 'delivered' && $userId) {
                // Get order items
                $orderItems = $this->getOrderItems($orderId);
                
                // Update stock for each item
                $productModel = new Product();
                foreach ($orderItems as $item) {
                    $productModel->updateStock(
                        $item['product_id'], 
                        $item['quantity'], 
                        $userId, 
                        'in', 
                        'Order delivered: ' . $orderId,
                        $orderId
                    );
                }
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deleteOrder($orderId) {
        $this->db->beginTransaction();
        
        try {
            // Delete order items first (due to foreign key constraint)
            $stmt = $this->db->prepare("DELETE FROM order_items WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Delete order
            $stmt = $this->db->prepare("DELETE FROM orders WHERE order_id = :order_id");
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function receiveOrder($orderId, $userId) {
        $this->db->beginTransaction();
        
        try {
            // Get order items
            $orderItems = $this->getOrderItems($orderId);
            
            // Update stock for each item
            $productModel = new Product();
            foreach ($orderItems as $item) {
                $productModel->updateStock(
                    $item['product_id'], 
                    $item['quantity'], 
                    $userId, 
                    'order_received', 
                    'Order received: ' . $orderId,
                    $orderId
                );
            }
            
            // Update order status
            $this->updateOrderStatus($orderId, 'received');
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getOrdersByStatus($status) {
        $stmt = $this->db->prepare("
            SELECT o.*, s.supplier_name, u.full_name as created_by_name
            FROM orders o
            JOIN suppliers s ON o.supplier_id = s.supplier_id
            JOIN users u ON o.created_by = u.user_id
            WHERE o.status = :status
            ORDER BY o.created_at DESC
        ");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersBySupplier($supplierId) {
        $stmt = $this->db->prepare("
            SELECT o.*, s.supplier_name, u.full_name as created_by_name
            FROM orders o
            JOIN suppliers s ON o.supplier_id = s.supplier_id
            JOIN users u ON o.created_by = u.user_id
            WHERE o.supplier_id = :supplier_id
            ORDER BY o.created_at DESC
        ");
        $stmt->bindParam(':supplier_id', $supplierId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generateOrderNumber() {
        $prefix = 'ORD';
        $year = date('Y');
        $month = date('m');
        
        // Get the highest order number for this month to avoid conflicts
        $stmt = $this->db->prepare("
            SELECT order_number FROM orders 
            WHERE order_number LIKE :pattern 
            ORDER BY order_number DESC 
            LIMIT 1
        ");
        $pattern = $prefix . $year . $month . '%';
        $stmt->bindParam(':pattern', $pattern);
        $stmt->execute();
        $lastOrderNumber = $stmt->fetchColumn();
        
        if ($lastOrderNumber) {
            // Extract the sequence number from the last order number
            $sequence = intval(substr($lastOrderNumber, -4));
            $sequence++;
        } else {
            // No orders for this month yet, start with 1
            $sequence = 1;
        }
        
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalOrdersCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM orders");
        return $stmt->fetchColumn();
    }

    public function getPendingOrdersCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
        return $stmt->fetchColumn();
    }
} 