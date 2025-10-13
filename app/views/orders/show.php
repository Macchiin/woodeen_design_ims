<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-file-invoice"></i> Order Details
                    </h1>
                    <div>
                        <a href="/wooden_design_ims/orders" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <?php if ($order['status'] != 'delivered' && $order['status'] != 'cancelled'): ?>
                            <a href="/wooden_design_ims/orders/edit/<?php echo $order['order_id']; ?>" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Order
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary" disabled>
                                <i class="fas fa-lock"></i> Edit Disabled
                            </button>
                        <?php endif; ?>
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

                <div class="row">
                    <!-- Order Information -->
                    <div class="col-md-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle"></i> Order Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Order ID:</label>
                                            <p class="mb-0 h5">#<?php echo htmlspecialchars($order['order_id']); ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Order Date:</label>
                                            <p class="mb-0"><?php echo date('F j, Y', strtotime($order['order_date'])); ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Expected Delivery:</label>
                                            <p class="mb-0"><?php echo date('F j, Y', strtotime($order['expected_delivery_date'])); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Supplier:</label>
                                            <p class="mb-0"><?php echo htmlspecialchars($order['supplier_name']); ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Total Amount:</label>
                                            <p class="mb-0 h5 text-success">$<?php echo number_format($order['total_amount'], 2); ?></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-muted">Notes:</label>
                                            <p class="mb-0"><?php echo !empty($order['notes']) ? htmlspecialchars($order['notes']) : 'No notes'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-list"></i> Order Items
                                </h6>
                            </div>
                            <div class="card-body">
                                <?php if (empty($orderItems)): ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No items found in this order.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th><i class="fas fa-box"></i> Product</th>
                                                    <th><i class="fas fa-barcode"></i> Code</th>
                                                    <th><i class="fas fa-sort-numeric-up"></i> Quantity</th>
                                                    <th><i class="fas fa-dollar-sign"></i> Unit Price</th>
                                                    <th><i class="fas fa-calculator"></i> Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orderItems as $item): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bold"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                                                <small class="text-muted"><?php echo htmlspecialchars($item['product_code']); ?></small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">
                                                                <?php echo htmlspecialchars($item['product_code']); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary"><?php echo $item['quantity']; ?></span>
                                                        </td>
                                                        <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                                                        <td>
                                                            <span class="fw-bold text-success">
                                                                $<?php echo number_format($item['total_price'], 2); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td colspan="4" class="text-end fw-bold">Total:</td>
                                                    <td class="fw-bold text-success h5">$<?php echo number_format($order['total_amount'], 2); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status & Actions -->
                    <div class="col-md-4">
                        <!-- Status Update Card -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-tasks"></i> Order Status
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Current Status -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-muted">Current Status:</label>
                                    <?php
                                    $statusClass = '';
                                    $statusIcon = '';
                                    switch ($order['status']) {
                                        case 'pending':
                                            $statusClass = 'bg-warning';
                                            $statusIcon = 'fas fa-clock';
                                            break;
                                        case 'confirmed':
                                            $statusClass = 'bg-info';
                                            $statusIcon = 'fas fa-check';
                                            break;
                                        case 'shipped':
                                            $statusClass = 'bg-primary';
                                            $statusIcon = 'fas fa-shipping-fast';
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
                                    <div class="mt-2">
                                        <span class="badge <?php echo $statusClass; ?> fs-6">
                                            <i class="<?php echo $statusIcon; ?>"></i>
                                            <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Status Update Form -->
                                <?php if ($order['status'] != 'delivered' && $order['status'] != 'cancelled'): ?>
                                    <form action="/wooden_design_ims/orders/updateStatus/<?php echo $order['order_id']; ?>" method="POST">
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold text-muted">Update Status:</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="delivered" <?php echo ($order['status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-save"></i> Update Status
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Status Locked:</strong> This order cannot be modified as it is <?php echo $order['status']; ?>.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-bolt"></i> Quick Actions
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">

                                    
                                    <?php if ($order['status'] != 'delivered' && $order['status'] != 'cancelled'): ?>
                                        <a href="/wooden_design_ims/orders/edit/<?php echo $order['order_id']; ?>" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit Order
                                        </a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-outline-secondary" disabled>
                                            <i class="fas fa-lock"></i> Edit Disabled (<?php echo ucfirst($order['status']); ?>)
                                        </button>
                                    <?php endif; ?>
                                    
                                    <a href="/wooden_design_ims/orders" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-list"></i> View All Orders
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            onclick="if(confirm('Are you sure you want to delete this order?')) window.location.href='/wooden_design_ims/orders/delete/<?php echo $order['order_id']; ?>'">
                                        <i class="fas fa-trash"></i> Delete Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Status change confirmation
        $('#status').on('change', function() {
            const newStatus = $(this).val();
            const currentStatus = '<?php echo $order['status']; ?>';
            
            if (newStatus !== currentStatus) {
                // You can add additional confirmation logic here if needed
                console.log('Status will be changed from', currentStatus, 'to', newStatus);
            }
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 