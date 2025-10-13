-- Database Schema for Wooden Design Inventory Management System
-- Based on UML Use Case Requirements

-- Drop existing tables if they exist (for clean setup)
DROP TABLE IF EXISTS inventory_logs;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS transaction_items;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS brands;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS users;

-- Create users table (for Admin and Staff roles)
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    staff_id VARCHAR(20) UNIQUE NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    email VARCHAR(100) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create brands table
CREATE TABLE brands (
    brand_id INT PRIMARY KEY AUTO_INCREMENT,
    brand_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create suppliers table
CREATE TABLE suppliers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table (inventory items)
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(200) NOT NULL,
    product_code VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    category_id INT NOT NULL,
    brand_id INT NOT NULL,
    supplier_id INT NOT NULL,
    current_stock INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    reorder_level INT NOT NULL DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE RESTRICT,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id) ON DELETE RESTRICT,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id) ON DELETE RESTRICT
);

-- Create orders table (for Manage Orders feature)
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    supplier_id INT NOT NULL,
    order_date DATE NOT NULL,
    expected_delivery_date DATE,
    status ENUM('pending', 'ordered', 'received', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10,2) DEFAULT 0.00,
    notes TEXT,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id) ON DELETE RESTRICT,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE RESTRICT
);

-- Create order_items table
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT
);

-- Create inventory_logs table (for Update Inventory tracking)
CREATE TABLE inventory_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    action_type ENUM('stock_in', 'stock_out', 'adjustment', 'order_received') NOT NULL,
    quantity_change INT NOT NULL,
    previous_stock INT NOT NULL,
    new_stock INT NOT NULL,
    reason TEXT,
    reference_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE RESTRICT
);

-- Insert default admin user
INSERT INTO users (username, password_hash, full_name, staff_id, role, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'ADMIN001', 'admin', 'admin@woodendesign.com');

-- Insert default categories
INSERT INTO categories (category_name, description) VALUES
('Wood Materials', 'Various types of wood materials'),
('Hardware', 'Nails, screws, hinges, and other hardware'),
('Finishing Materials', 'Paints, varnishes, and finishing products'),
('Tools', 'Hand tools and power tools'),
('Packaging', 'Packaging materials and supplies');

-- Insert default brands
INSERT INTO brands (brand_name, description) VALUES
('Generic', 'Generic brand products'),
('Premium Wood', 'High-quality wood materials'),
('ToolMaster', 'Professional grade tools'),
('FinishPro', 'Professional finishing materials');

-- Insert default suppliers
INSERT INTO suppliers (supplier_name, contact_person, email, phone, address) VALUES
('Wood Supply Co.', 'John Smith', 'john@woodsupply.com', '+1234567890', '123 Wood Street, City, State'),
('Hardware Plus', 'Jane Doe', 'jane@hardwareplus.com', '+1234567891', '456 Hardware Ave, City, State'),
('Tool World', 'Mike Johnson', 'mike@toolworld.com', '+1234567892', '789 Tool Road, City, State');

-- Create indexes for better performance
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_brand ON products(brand_id);
CREATE INDEX idx_products_supplier ON products(supplier_id);
CREATE INDEX idx_products_stock ON products(current_stock, reorder_level);
CREATE INDEX idx_orders_supplier ON orders(supplier_id);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_inventory_logs_product ON inventory_logs(product_id);
CREATE INDEX idx_inventory_logs_user ON inventory_logs(user_id);
CREATE INDEX idx_inventory_logs_date ON inventory_logs(created_at); 