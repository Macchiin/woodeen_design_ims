<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Logs - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-history"></i> Inventory Logs
                        <?php if ($product): ?>
                            - <?php echo htmlspecialchars($product['product_name']); ?>
                        <?php endif; ?>
                    </h1>
                    <div>
                        <?php if ($product): ?>
                            <a href="/wooden_design_ims/products" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Back to Products
                            </a>
                        <?php endif; ?>
                        <a href="/wooden_design_ims/products" class="btn btn-primary">
                            <i class="fas fa-box"></i> View All Products
                        </a>
                    </div>
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

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> Transaction History
                            <?php if ($product): ?>
                                for <?php echo htmlspecialchars($product['product_name']); ?>
                            <?php endif; ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($logs)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No inventory logs found</h5>
                                <p class="text-muted">
                                    <?php if ($product): ?>
                                        No transactions have been recorded for this product yet.
                                    <?php else: ?>
                                        No inventory transactions have been recorded yet.
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th><i class="fas fa-calendar"></i> Date & Time</th>
                                            <?php if (!$product): ?>
                                                <th><i class="fas fa-box"></i> Product</th>
                                            <?php endif; ?>
                                            <th><i class="fas fa-user"></i> User</th>
                                            <th><i class="fas fa-exchange-alt"></i> Action</th>
                                            <th><i class="fas fa-sort-numeric-up"></i> Quantity Change</th>
                                            <th><i class="fas fa-chart-line"></i> Stock Level</th>
                                            <th><i class="fas fa-comment"></i> Reason</th>
                                            <th><i class="fas fa-hashtag"></i> Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($logs as $log): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold">
                                                            <?php echo date('M j, Y', strtotime($log['created_at'])); ?>
                                                        </span>
                                                        <small class="text-muted">
                                                            <?php echo date('g:i A', strtotime($log['created_at'])); ?>
                                                        </small>
                                                    </div>
                                                </td>
                                                <?php if (!$product): ?>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold">
                                                                <?php echo htmlspecialchars($log['product_name']); ?>
                                                            </span>
                                                            <small class="text-muted">
                                                                <?php echo htmlspecialchars($log['product_code']); ?>
                                                            </small>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-user"></i>
                                                        <?php echo htmlspecialchars($log['user_name']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $actionClass = '';
                                                    $actionIcon = '';
                                                    $actionText = '';
                                                    switch ($log['action_type']) {
                                                        case 'stock_in':
                                                            $actionClass = 'bg-success';
                                                            $actionIcon = 'fas fa-arrow-down';
                                                            $actionText = 'Stock In';
                                                            break;
                                                        case 'stock_out':
                                                            $actionClass = 'bg-danger';
                                                            $actionIcon = 'fas fa-arrow-up';
                                                            $actionText = 'Stock Out';
                                                            break;
                                                        case 'adjustment':
                                                            $actionClass = 'bg-warning';
                                                            $actionIcon = 'fas fa-edit';
                                                            $actionText = 'Adjustment';
                                                            break;
                                                        case 'order_received':
                                                            $actionClass = 'bg-info';
                                                            $actionIcon = 'fas fa-truck';
                                                            $actionText = 'Order Received';
                                                            break;
                                                        default:
                                                            $actionClass = 'bg-secondary';
                                                            $actionIcon = 'fas fa-exchange-alt';
                                                            $actionText = ucfirst(htmlspecialchars($log['action_type']));
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $actionClass; ?>">
                                                        <i class="<?php echo $actionIcon; ?>"></i>
                                                        <?php echo $actionText; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Determine if this is an increase or decrease based on action type
                                                    $isIncrease = in_array($log['action_type'], ['stock_in', 'order_received']);
                                                    $isDecrease = in_array($log['action_type'], ['stock_out']);
                                                    $isAdjustment = $log['action_type'] === 'adjustment';
                                                    
                                                    if ($isIncrease) {
                                                        $quantityClass = 'text-success';
                                                        $quantityIcon = 'fas fa-plus';
                                                        $quantityPrefix = '+';
                                                    } elseif ($isDecrease) {
                                                        $quantityClass = 'text-danger';
                                                        $quantityIcon = 'fas fa-minus';
                                                        $quantityPrefix = '-';
                                                    } else {
                                                        // For adjustments, show the actual change
                                                        $actualChange = $log['new_stock'] - $log['previous_stock'];
                                                        if ($actualChange > 0) {
                                                            $quantityClass = 'text-success';
                                                            $quantityIcon = 'fas fa-plus';
                                                            $quantityPrefix = '+';
                                                        } elseif ($actualChange < 0) {
                                                            $quantityClass = 'text-danger';
                                                            $quantityIcon = 'fas fa-minus';
                                                            $quantityPrefix = '';
                                                        } else {
                                                            $quantityClass = 'text-muted';
                                                            $quantityIcon = 'fas fa-equals';
                                                            $quantityPrefix = '';
                                                        }
                                                        $quantityChange = abs($actualChange);
                                                    }
                                                    
                                                    if (!$isAdjustment) {
                                                        $quantityChange = abs($log['quantity_change']);
                                                    }
                                                    ?>
                                                    <span class="<?php echo $quantityClass; ?> fw-bold">
                                                        <i class="<?php echo $quantityIcon; ?>"></i>
                                                        <?php echo $quantityPrefix . $quantityChange; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <small class="text-muted">Previous: <?php echo $log['previous_stock']; ?></small>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fw-bold text-primary me-1">→</span>
                                                            <span class="fw-bold <?php echo $log['new_stock'] > $log['previous_stock'] ? 'text-success' : ($log['new_stock'] < $log['previous_stock'] ? 'text-danger' : 'text-primary'); ?>">
                                                                <?php echo $log['new_stock']; ?>
                                                            </span>
                                                            <?php if ($log['new_stock'] > $log['previous_stock']): ?>
                                                                <i class="fas fa-arrow-up text-success ms-1"></i>
                                                            <?php elseif ($log['new_stock'] < $log['previous_stock']): ?>
                                                                <i class="fas fa-arrow-down text-danger ms-1"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($log['reason'])): ?>
                                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?php echo htmlspecialchars($log['reason']); ?>">
                                                            <?php echo htmlspecialchars($log['reason']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($log['reference_number'])): ?>
                                                        <span class="badge bg-light text-dark">
                                                            <?php echo htmlspecialchars($log['reference_number']); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary Statistics -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-list fa-2x mb-2"></i>
                                            <h5><?php echo count($logs); ?></h5>
                                            <small>Total Transactions</small>
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
        // Initialize tooltips
        $('[title]').tooltip();
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 