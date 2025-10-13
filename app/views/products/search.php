<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-search"></i> Search Products
                    </h1>
                    <a href="/wooden_design_ims/products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>

                <!-- Search Form -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-search"></i> Search Products
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/products/search" method="GET" class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" name="q" 
                                           value="<?php echo htmlspecialchars($searchTerm); ?>" 
                                           placeholder="Search by product name, code, or description...">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a href="/wooden_design_ims/products" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear Search
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Search Results -->
                <?php if (!empty($searchTerm)): ?>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-list"></i> Search Results
                                <span class="badge bg-primary ms-2"><?php echo count($products); ?> found</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (empty($products)): ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products found</h5>
                                    <p class="text-muted">
                                        No products match your search term: "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>"
                                    </p>
                                    <a href="/wooden_design_ims/products" class="btn btn-primary">
                                        <i class="fas fa-list"></i> View All Products
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th><i class="fas fa-box"></i> Product</th>
                                                <th><i class="fas fa-tag"></i> Code</th>
                                                <th><i class="fas fa-folder"></i> Category</th>
                                                <th><i class="fas fa-trademark"></i> Brand</th>
                                                <th><i class="fas fa-truck"></i> Supplier</th>
                                                <th><i class="fas fa-boxes"></i> Stock</th>
                                                <th><i class="fas fa-dollar-sign"></i> Price</th>
                                                <th><i class="fas fa-cogs"></i> Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold">
                                                                <?php echo htmlspecialchars($product['product_name']); ?>
                                                            </span>
                                                            <?php if (!empty($product['description'])): ?>
                                                                <small class="text-muted">
                                                                    <?php echo htmlspecialchars(substr($product['description'], 0, 50)) . (strlen($product['description']) > 50 ? '...' : ''); ?>
                                                                </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            <?php echo htmlspecialchars($product['product_code']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            <?php echo htmlspecialchars($product['brand_name']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small><?php echo htmlspecialchars($product['supplier_name']); ?></small>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $stockClass = '';
                                                        if ($product['current_stock'] <= $product['reorder_level']) {
                                                            $stockClass = 'bg-danger';
                                                        } elseif ($product['current_stock'] <= $product['reorder_level'] * 2) {
                                                            $stockClass = 'bg-warning';
                                                        } else {
                                                            $stockClass = 'bg-success';
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $stockClass; ?>">
                                                            <?php echo $product['current_stock']; ?>
                                                        </span>
                                                        <small class="text-muted">/ <?php echo $product['reorder_level']; ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            $<?php echo number_format($product['unit_price'], 2); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="/wooden_design_ims/products/edit/<?php echo $product['product_id']; ?>" 
                                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="/wooden_design_ims/products/updateStock/<?php echo $product['product_id']; ?>" 
                                                               class="btn btn-sm btn-outline-warning" title="Update Stock">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="/wooden_design_ims/products/inventoryLogs/<?php echo $product['product_id']; ?>" 
                                                               class="btn btn-sm btn-outline-info" title="View Logs">
                                                                <i class="fas fa-history"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Search Summary -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            Found <strong><?php echo count($products); ?></strong> product(s) matching 
                                            "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>"
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="/wooden_design_ims/products" class="btn btn-primary">
                                            <i class="fas fa-list"></i> View All Products
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Auto-focus search input
        $('input[name="q"]').focus();
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 