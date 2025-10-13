<?php
// app/models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Returns the PDO database connection instance.
     * This is useful for initiating transactions (beginTransaction, commit, rollBack)
     * from controllers or services that use this model.
     * @return PDO The PDO database connection object.
     */
    public function getConnection() {
        return $this->db;
    }

    public function getAllProducts() {
        $stmt = $this->db->query("
            SELECT p.*, c.category_name, b.brand_name, s.supplier_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN suppliers s ON p.supplier_id = s.supplier_id
            ORDER BY p.product_name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.category_name, b.brand_name, s.supplier_name
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            JOIN suppliers s ON p.supplier_id = s.supplier_id
            WHERE p.product_id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($data) {
        $stmt = $this->db->prepare("
            INSERT INTO products (product_name, product_code, description, category_id, brand_id, supplier_id, current_stock, unit_price, reorder_level) 
            VALUES (:product_name, :product_code, :description, :category_id, :brand_id, :supplier_id, :current_stock, :unit_price, :reorder_level)
        ");
        return $stmt->execute($data);
    }

    public function updateProduct($id, $data) {
        $data['product_id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE products 
            SET product_name = :product_name, product_code = :product_code, description = :description, 
                category_id = :category_id, brand_id = :brand_id, supplier_id = :supplier_id, 
                current_stock = :current_stock, unit_price = :unit_price, reorder_level = :reorder_level, 
                updated_at = NOW() 
            WHERE product_id = :product_id
        ");
        return $stmt->execute($data);
    }

    public function deleteProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateStock($productId, $quantityChange, $userId, $actionType = 'adjustment', $reason = '', $referenceNumber = '') {
        $this->db->beginTransaction();
        
        try {
            // Get current stock
            $stmt = $this->db->prepare("SELECT current_stock FROM products WHERE product_id = :productId");
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $currentStock = $stmt->fetchColumn();
            
            // Calculate new stock based on action type
            switch ($actionType) {
                case 'stock_in':
                case 'in':
                    $newStock = $currentStock + $quantityChange;
                    $actionType = 'stock_in'; // Normalize to database enum
                    break;
                case 'stock_out':
                case 'out':
                    $newStock = $currentStock - $quantityChange;
                    $actionType = 'stock_out'; // Normalize to database enum
                    break;
                case 'adjustment':
                    $newStock = $quantityChange; // For adjustment, quantity becomes the new stock level
                    break;
                case 'order_received':
                    $newStock = $currentStock + $quantityChange;
                    break;
                default:
                    $newStock = $currentStock + $quantityChange; // Default to stock in
                    $actionType = 'stock_in';
            }
            
            // Validate stock out doesn't go negative
            if ($newStock < 0) {
                throw new Exception("Insufficient stock. Cannot reduce stock below 0.");
            }
            
            // Update product stock
            $stmt = $this->db->prepare("UPDATE products SET current_stock = :newStock WHERE product_id = :productId");
            $stmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Log the inventory change
            $stmt = $this->db->prepare("
                INSERT INTO inventory_logs (product_id, user_id, action_type, quantity_change, previous_stock, new_stock, reason, reference_number)
                VALUES (:product_id, :user_id, :action_type, :quantity_change, :previous_stock, :new_stock, :reason, :reference_number)
            ");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':action_type', $actionType);
            $stmt->bindParam(':quantity_change', $quantityChange, PDO::PARAM_INT);
            $stmt->bindParam(':previous_stock', $currentStock, PDO::PARAM_INT);
            $stmt->bindParam(':new_stock', $newStock, PDO::PARAM_INT);
            $stmt->bindParam(':reason', $reason);
            $stmt->bindParam(':reference_number', $referenceNumber);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getLowStockProducts() {
        $stmt = $this->db->query("
            SELECT p.product_name, p.product_code, p.current_stock, p.reorder_level, 
                   COALESCE(c.category_name, 'Uncategorized') as category_name, 
                   COALESCE(s.supplier_name, 'Unknown Supplier') as supplier_name, 
                   s.contact_person, s.email, s.phone
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
            WHERE p.current_stock <= p.reorder_level
            ORDER BY p.current_stock ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockCount() {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM products 
            WHERE current_stock <= reorder_level
        ");
        return $stmt->fetchColumn();
    }

    public function getTotalProductsCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    }

    public function getInventoryLogs($productId = null, $limit = 50) {
        $sql = "
            SELECT il.*, p.product_name, p.product_code, u.full_name as user_name
            FROM inventory_logs il
            JOIN products p ON il.product_id = p.product_id
            JOIN users u ON il.user_id = u.user_id
        ";
        
        if ($productId) {
            $sql .= " WHERE il.product_id = :product_id";
        }
        
        $sql .= " ORDER BY il.created_at DESC LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        
        if ($productId) {
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $stmt = $this->db->prepare("
            SELECT p.*, 
                   COALESCE(c.category_name, 'Uncategorized') as category_name,
                   COALESCE(b.brand_name, 'Unbranded') as brand_name,
                   COALESCE(s.supplier_name, 'Unknown Supplier') as supplier_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN brands b ON p.brand_id = b.brand_id
            LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
            WHERE p.product_name LIKE :search1 OR p.product_code LIKE :search2 OR p.description LIKE :search3
            ORDER BY p.product_name
        ");
        $stmt->bindParam(':search1', $searchTerm);
        $stmt->bindParam(':search2', $searchTerm);
        $stmt->bindParam(':search3', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}