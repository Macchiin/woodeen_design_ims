<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Low Stock Alerts
                </h1>
                <a href="/wooden_design_ims/products" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>

            <!-- Alert Summary -->
            <div class="row mb-4">
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

            <!-- Low Stock Products Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-exclamation-triangle"></i> Products Requiring Reorder
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($lowStockProducts)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-success">Great! All products have sufficient stock levels.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="lowStockTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Reorder Level</th>
                                        <th>Supplier</th>
                                        <th>Contact Info</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lowStockProducts as $product): ?>
                                        <tr class="table-warning">
                                            <td>
                                                <strong><?= htmlspecialchars($product['product_code']) ?></strong>
                                            </td>
                                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                                            <td><?= htmlspecialchars($product['category_name']) ?></td>
                                            <td>
                                                <span class="text-danger font-weight-bold">
                                                    <?= $product['current_stock'] ?>
                                                </span>
                                            </td>
                                            <td><?= $product['reorder_level'] ?></td>
                                            <td><?= htmlspecialchars($product['supplier_name']) ?></td>
                                            <td>
                                                <div class="small">
                                                    <div><strong>Contact:</strong> <?= htmlspecialchars($product['contact_person']) ?></div>
                                                    <div><strong>Email:</strong> <?= htmlspecialchars($product['email']) ?></div>
                                                    <div><strong>Phone:</strong> <?= htmlspecialchars($product['phone']) ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/wooden_design_ims/orders/create" class="btn btn-sm btn-primary" 
                                                       title="Create Order">
                                                        <i class="fas fa-shopping-cart"></i> Order
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb"></i> Quick Actions
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="/wooden_design_ims/orders/create" class="btn btn-primary btn-block">
                                                    <i class="fas fa-plus"></i> Create New Order
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#lowStockTable').DataTable({
        "order": [[3, "asc"]], // Sort by current stock (lowest first)
        "pageLength": 25,
        "language": {
            "search": "Search low stock items:",
            "lengthMenu": "Show _MENU_ items per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ low stock items"
        }
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?> 