<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-boxes"></i> Manage Inventory
                    </h1>
                    <div>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <a href="/wooden_design_ims/products/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                        <?php endif; ?>
                        <a href="/wooden_design_ims/products/lowStock" class="btn btn-warning">
                            <i class="fas fa-exclamation-triangle"></i> Low Stock (<?= $lowStockCount ?>)
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Products</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProducts ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Low Stock Items</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $lowStockCount ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="GET" action="/wooden_design_ims/products/search" class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="q" placeholder="Search products by name, code, or description..." 
                                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="/wooden_design_ims/products" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($products)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-boxes fa-3x text-gray-300 mb-3"></i>
                                <p class="text-gray-500">No products found. Add your first product!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product Code</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Supplier</th>
                                            <th>Current Stock</th>
                                            <th>Unit Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr class="<?= $product['current_stock'] <= $product['reorder_level'] ? 'table-warning' : '' ?>">
                                                <td>
                                                    <strong><?= htmlspecialchars($product['product_code']) ?></strong>
                                                </td>
                                                <td><?= htmlspecialchars($product['product_name']) ?></td>
                                                <td><?= htmlspecialchars($product['category_name']) ?></td>
                                                <td><?= htmlspecialchars($product['brand_name']) ?></td>
                                                <td><?= htmlspecialchars($product['supplier_name']) ?></td>
                                                <td>
                                                    <span class="<?= $product['current_stock'] <= $product['reorder_level'] ? 'text-danger font-weight-bold' : '' ?>">
                                                        <?= $product['current_stock'] ?>
                                                    </span>
                                                    <?php if ($product['current_stock'] <= $product['reorder_level']): ?>
                                                        <i class="fas fa-exclamation-triangle text-warning ml-1" title="Low Stock"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>$<?= number_format($product['unit_price'], 2) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="/wooden_design_ims/products/updateStock/<?= $product['product_id'] ?>" 
                                                           class="btn btn-sm btn-info" title="Update Stock">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="/wooden_design_ims/products/inventoryLogs/<?= $product['product_id'] ?>" 
                                                           class="btn btn-sm btn-secondary" title="View Logs">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                                            <a href="/wooden_design_ims/products/edit/<?= $product['product_id'] ?>" 
                                                               class="btn btn-sm btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="/wooden_design_ims/products/delete/<?= $product['product_id'] ?>" 
                                                               class="btn btn-sm btn-danger" title="Delete"
                                                               onclick="return confirm('Are you sure you want to delete this product?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            "order": [[0, "asc"]], // Sort by product code
            "pageLength": 25,
            "language": {
                "search": "Search products:",
                "lengthMenu": "Show _MENU_ products per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ products"
            }
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <style>
        /* Basic table and button styles (can be moved to style.css if not already there) */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { display: inline-block; padding: 8px 12px; margin-right: 5px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .button.edit { background-color: #ffc107; }
        .button.delete { background-color: #dc3545; }
        .button.cancel { background-color: #6c757d; }
        .button:hover { opacity: 0.9; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</body>
</html>