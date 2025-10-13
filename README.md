# Wooden Design Inventory Management System

A comprehensive web-based inventory management system designed specifically for wooden design businesses. Built with PHP, MySQL, and modern web technologies.

## 🌟 Features

### Core Functionality
- **Product Management**: Add, edit, delete, and track wooden products
- **Inventory Tracking**: Real-time stock monitoring with low stock alerts
- **Category Management**: Organize products by categories (Wood Materials, Hardware, Finishing Materials, Tools, Packaging)
- **Brand Management**: Track products by different brands
- **Supplier Management**: Manage supplier information and contacts
- **Order Management**: Create and track purchase orders
- **User Management**: Admin and staff role-based access control

### Dashboard Features
- **Real-time Statistics**: Total products, low stock alerts, pending orders
- **Low Stock Alerts**: Automatic notifications for products below reorder level
- **Recent Activity**: Track recent inventory changes and orders
- **Quick Actions**: Fast access to common tasks

### User Roles
- **Admin**: Full system access, user management, all CRUD operations
- **Staff**: Limited access to inventory management and reporting

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Architecture**: MVC (Model-View-Controller)
- **Server**: Apache (XAMPP recommended)

## 📋 Prerequisites

- **XAMPP** (Apache + MySQL + PHP) or similar LAMP/WAMP stack
- **PHP 7.4** or higher
- **MySQL 5.7** or higher
- **Web Browser** (Chrome, Firefox, Safari, Edge)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/wooden-design-ims.git
cd wooden-design-ims
```

### 2. Setup XAMPP
1. Download and install [XAMPP](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Place the project folder in `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)

### 3. Database Setup
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create a new database named `wooden_design_ims`
3. Import the database schema:
```sql
-- Run the database_schema.sql file in phpMyAdmin
-- Or execute: mysql -u root -p < database_schema.sql
```

### 4. Configuration
1. Update database configuration in `app/config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'wooden_design_ims');
define('DB_USER', 'root');
define('DB_PASS', ''); // Your MySQL password
```

### 5. Access the Application
1. Open your browser and navigate to: `http://localhost/wooden_design_ims`
2. Use the default admin credentials:
   - **Username**: `admin`
   - **Password**: `admin123`

## 📁 Project Structure

```
wooden-design-ims/
├── app/
│   ├── config/
│   │   └── database.php          # Database configuration
│   ├── controllers/              # MVC Controllers
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   ├── UserController.php
│   │   └── ...
│   ├── core/
│   │   ├── Database.php          # Database connection class
│   │   └── helpers.php           # Helper functions
│   ├── models/                   # MVC Models
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── ...
│   └── views/                    # MVC Views
│       ├── auth/
│       ├── dashboard/
│       ├── products/
│       └── ...
├── public/
│   ├── assets/
│   │   ├── css/                  # Stylesheets
│   │   ├── js/                   # JavaScript files
│   │   └── images/               # Images and icons
│   └── index.php                 # Application entry point
├── database_schema.sql           # Database structure
├── README.md                     # This file
└── composer.json                 # PHP dependencies
```

## 🔐 Default Admin Account

The system comes with a default admin account:

- **Username**: `admin`
- **Password**: `admin123`
- **Email**: admin@woodendesign.com

**⚠️ Security Note**: Change the default password immediately after installation!

## 📊 Database Schema

The system includes the following main tables:

- **users**: Admin and staff accounts
- **products**: Product inventory
- **categories**: Product categories
- **brands**: Product brands
- **suppliers**: Supplier information
- **orders**: Purchase orders
- **order_items**: Order line items
- **inventory_logs**: Inventory change tracking

## 🎯 Usage

### For Administrators
1. **Dashboard**: Monitor system overview and alerts
2. **User Management**: Create and manage staff accounts
3. **Product Management**: Add/edit products, categories, and brands
4. **Supplier Management**: Maintain supplier database
5. **Order Management**: Create and track purchase orders

### For Staff
1. **Inventory Updates**: Update stock levels and track changes
2. **Product Information**: View product details and availability
3. **Order Processing**: Handle incoming orders and deliveries

## 🔧 Configuration

### Database Connection
Edit `app/config/database.php` to match your database settings:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'wooden_design_ims');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### Application URL
Update the base URL in your configuration if not using localhost:

```php
define('BASE_URL', 'http://yourdomain.com/wooden-design-ims/');
```

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify XAMPP MySQL service is running
   - Check database credentials in `app/config/database.php`
   - Ensure database `wooden_design_ims` exists

2. **Login Issues**
   - Clear browser cookies and cache
   - Verify admin account exists in database
   - Check session configuration

3. **Permission Errors**
   - Ensure web server has read/write permissions
   - Check file ownership (Linux/Mac)

### Debug Mode
Enable debug mode by adding `?debug=1` to any URL to see session and error information.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Your Name** - *Initial work* - [YourGitHub](https://github.com/yourusername)

## 🙏 Acknowledgments

- Built for wooden design businesses
- Inspired by modern inventory management systems
- Uses industry-standard MVC architecture

## 📞 Support

For support, email your-email@example.com or create an issue in this repository.

---

**Made with ❤️ for the wooden design industry**