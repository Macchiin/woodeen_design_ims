<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </h1>
                    <div>
                        <span class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
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

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalOrders ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pending Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingOrders ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <?php if (!empty($lowStockProducts)): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-left-danger shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-danger">
                                    <i class="fas fa-exclamation-triangle"></i> Low Stock Alert
                                </h6>
                                <a href="/wooden_design_ims/products/lowStock" class="btn btn-sm btn-outline-danger">
                                    View All
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Code</th>
                                                <th>Current Stock</th>
                                                <th>Reorder Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($lowStockProducts, 0, 5) as $product): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($product['product_name']) ?></strong>
                                                </td>
                                                <td><?= htmlspecialchars($product['product_code']) ?></td>
                                                <td>
                                                    <span class="badge <?= $product['current_stock'] == 0 ? 'bg-danger' : 'bg-warning' ?>">
                                                        <?= $product['current_stock'] ?>
                                                    </span>
                                                </td>
                                                <td><?= $product['reorder_level'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (count($lowStockProducts) > 5): ?>
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Showing 5 of <?= count($lowStockProducts) ?> low stock items
                                    </small>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-left-success shadow">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-success">All Stock Levels Are Healthy!</h5>
                                <p class="text-muted mb-0">No products are currently below reorder level.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Inventory Activity</h6>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recentLogs)): ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach (array_slice($recentLogs, 0, 5) as $log): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= htmlspecialchars($log['product_name']) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= ucfirst($log['action_type']) ?></small>
                                        </div>
                                        <span class="badge badge-info"><?= $log['quantity_change'] ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <p class="text-muted text-center">No recent inventory activity</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
