<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-shopping-cart"></i> Manage Orders
                </h1>
                <a href="/wooden_design_ims/orders/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Order
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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

                                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Cancelled Orders</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php 
                                                        $cancelledCount = 0;
                                                        foreach ($orders as $order) {
                                                            if ($order['status'] == 'cancelled') $cancelledCount++;
                                                        }
                                                        echo $cancelledCount;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-times fa-2x text-gray-300"></i>
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
                                        Delivered Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                        $deliveredCount = 0;
                                        foreach ($orders as $order) {
                                            if ($order['status'] == 'delivered') $deliveredCount++;
                                        }
                                        echo $deliveredCount;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-double fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list"></i> All Orders
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No orders found</h5>
                            <p class="text-muted">Create your first order to get started!</p>
                            <a href="/wooden_design_ims/orders/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Order
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="ordersTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-hashtag"></i> Order #</th>
                                        <th><i class="fas fa-truck"></i> Supplier</th>
                                        <th><i class="fas fa-calendar"></i> Order Date</th>
                                        <th><i class="fas fa-calendar-check"></i> Expected Delivery</th>
                                        <th><i class="fas fa-dollar-sign"></i> Total Amount</th>
                                        <th><i class="fas fa-tasks"></i> Status</th>
                                        <th><i class="fas fa-user"></i> Created By</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-primary">#<?= htmlspecialchars($order['order_id']) ?></strong>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold"><?= htmlspecialchars($order['supplier_name']) ?></span>
                                                    <small class="text-muted"><?= htmlspecialchars($order['supplier_name']) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><?= date('M d, Y', strtotime($order['order_date'])) ?></span>
                                                    <small class="text-muted"><?= date('g:i A', strtotime($order['order_date'])) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($order['expected_delivery_date']): ?>
                                                    <div class="d-flex flex-column">
                                                        <span><?= date('M d, Y', strtotime($order['expected_delivery_date'])) ?></span>
                                                        <small class="text-muted">
                                                            <?php 
                                                            $deliveryDate = new DateTime($order['expected_delivery_date']);
                                                            $today = new DateTime();
                                                            $diff = $today->diff($deliveryDate);
                                                            if ($deliveryDate < $today) {
                                                                echo '<span class="text-danger">Overdue</span>';
                                                            } elseif ($diff->days <= 3) {
                                                                echo '<span class="text-warning">Due soon</span>';
                                                            } else {
                                                                echo $diff->days . ' days left';
                                                            }
                                                            ?>
                                                        </small>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Not set</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">$<?= number_format($order['total_amount'], 2) ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = '';
                                                $statusIcon = '';
                                                switch ($order['status']) {
                                                    case 'pending':
                                                        $statusClass = 'bg-warning';
                                                        $statusIcon = 'fas fa-clock';
                                                        break;
                                                    case 'delivered':
                                                        $statusClass = 'bg-success';
                                                        $statusIcon = 'fas fa-check-double';
                                                        break;
                                                    case 'cancelled':
                                                        $statusClass = 'bg-danger';
                                                        $statusIcon = 'fas fa-times';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        $statusIcon = 'fas fa-question';
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?> fs-6">
                                                    <i class="<?= $statusIcon ?>"></i>
                                                    <?= ucfirst(htmlspecialchars($order['status'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-user"></i>
                                                    <?= htmlspecialchars($order['created_by_name'] ?? 'Unknown') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/wooden_design_ims/orders/show/<?= $order['order_id'] ?>" 
                                                       class="btn btn-sm btn-outline-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($order['status'] != 'delivered' && $order['status'] != 'cancelled'): ?>
                                                        <a href="/wooden_design_ims/orders/edit/<?= $order['order_id'] ?>" 
                                                           class="btn btn-sm btn-outline-warning" title="Edit Order">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-secondary" 
                                                                title="Edit Disabled (<?= ucfirst($order['status']) ?>)"
                                                                disabled>
                                                            <i class="fas fa-lock"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete Order"
                                                            onclick="if(confirm('Are you sure you want to delete this order?')) window.location.href='/wooden_design_ims/orders/delete/<?= $order['order_id'] ?>'">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
    $('#ordersTable').DataTable({
        "order": [[2, "desc"]], // Sort by order date descending
        "pageLength": 25,
        "language": {
            "search": "Search orders:",
            "lengthMenu": "Show _MENU_ orders per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ orders"
        },
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting on Actions column
        ]
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?> 