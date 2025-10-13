<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stock - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit"></i> Update Stock Level
                    </h1>
                    <a href="/wooden_design_ims/products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="row">
                    <!-- Product Information Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-box"></i> Product Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Product Name:</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($product['product_name']); ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Product Code:</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($product['product_code']); ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Current Stock:</label>
                                    <div class="d-flex align-items-center">
                                        <span class="h4 mb-0 me-2"><?php echo $product['current_stock']; ?></span>
                                        <span class="badge bg-primary">units</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Reorder Level:</label>
                                    <p class="mb-0"><?php echo $product['reorder_level']; ?> units</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted">Unit Price:</label>
                                    <p class="mb-0">$<?php echo number_format($product['unit_price'], 2); ?></p>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label fw-bold text-muted">Category:</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Update Form -->
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-edit"></i> Update Stock Level
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="/wooden_design_ims/products/updateStock/<?php echo htmlspecialchars($product['product_id']); ?>" method="POST" id="updateStockForm">
                                    
                                    <!-- Action Type Selection -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-exchange-alt"></i> Transaction Type
                                            </h5>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="action_type" id="action_in" value="in" checked>
                                                <label class="form-check-label" for="action_in">
                                                    <i class="fas fa-arrow-down text-success"></i> Stock In
                                                </label>
                                                <div class="form-text">Add stock to current inventory</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="action_type" id="action_out" value="out">
                                                <label class="form-check-label" for="action_out">
                                                    <i class="fas fa-arrow-up text-danger"></i> Stock Out
                                                </label>
                                                <div class="form-text">Remove stock from current inventory</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="action_type" id="action_adjustment" value="adjustment">
                                                <label class="form-check-label" for="action_adjustment">
                                                    <i class="fas fa-edit text-warning"></i> Adjustment
                                                </label>
                                                <div class="form-text">Set exact stock level (overwrites current)</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quantity Change -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-sort-numeric-up"></i> Quantity Change
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity_change" class="form-label">
                                                    <i class="fas fa-calculator"></i> <span id="quantity_label">Quantity to Add</span> <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="quantity_change" name="quantity_change" 
                                                       min="1" value="1" required>
                                                <div class="form-text" id="quantity_help">Enter the quantity to add to inventory</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-chart-line"></i> New Stock Level
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Will be:</span>
                                                    <input type="text" class="form-control" id="new_stock_preview" 
                                                           value="<?php echo $product['current_stock'] + 1; ?>" readonly>
                                                    <span class="input-group-text">units</span>
                                                </div>
                                                <div class="form-text">Preview of new stock level</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reference Information -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-info-circle"></i> Reference Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reference_number" class="form-label">
                                                    <i class="fas fa-hashtag"></i> Reference Number
                                                </label>
                                                <input type="text" class="form-control" id="reference_number" name="reference_number" 
                                                       placeholder="e.g., PO-12345, Invoice-001">
                                                <div class="form-text">Optional: Purchase order, invoice, or other reference</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reason" class="form-label">
                                                    <i class="fas fa-comment"></i> Reason
                                                </label>
                                                <input type="text" class="form-control" id="reason" name="reason" 
                                                       placeholder="e.g., New shipment, Customer order, Stock correction">
                                                <div class="form-text">Optional: Reason for this stock change</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="my-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="/wooden_design_ims/products" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Update Stock
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        const currentStock = <?php echo $product['current_stock']; ?>;
        const quantityInput = $('#quantity_change');
        const newStockPreview = $('#new_stock_preview');
        const actionTypeInputs = $('input[name="action_type"]');

        // Update preview when quantity changes
        function updatePreview() {
            const quantity = parseInt(quantityInput.val()) || 0;
            const actionType = $('input[name="action_type"]:checked').val();
            
            let newStock = currentStock;
            if (actionType === 'in') {
                newStock = currentStock + quantity;
            } else if (actionType === 'out') {
                newStock = currentStock - quantity;
            } else if (actionType === 'adjustment') {
                newStock = quantity; // For adjustment, quantity becomes the new stock level
            }
            
            newStockPreview.val(newStock);
            
            // Color coding for preview
            if (newStock < 0) {
                newStockPreview.addClass('text-danger').removeClass('text-success text-warning');
            } else if (newStock > currentStock) {
                newStockPreview.addClass('text-success').removeClass('text-danger text-warning');
            } else if (newStock < currentStock) {
                newStockPreview.addClass('text-warning').removeClass('text-success text-danger');
            } else {
                newStockPreview.removeClass('text-success text-danger text-warning');
            }
        }

        // Update preview when quantity or action type changes
        quantityInput.on('input', updatePreview);
        actionTypeInputs.on('change', function() {
            updatePreview();
            updateLabels();
        });
        
        // Update labels based on action type
        function updateLabels() {
            const actionType = $('input[name="action_type"]:checked').val();
            const quantityLabel = $('#quantity_label');
            const quantityHelp = $('#quantity_help');
            
            switch (actionType) {
                case 'in':
                    quantityLabel.text('Quantity to Add');
                    quantityHelp.text('Enter the quantity to add to inventory');
                    break;
                case 'out':
                    quantityLabel.text('Quantity to Remove');
                    quantityHelp.text('Enter the quantity to remove from inventory');
                    break;
                case 'adjustment':
                    quantityLabel.text('New Stock Level');
                    quantityHelp.text('Enter the exact stock level (overwrites current)');
                    break;
            }
        }

        // Form validation
        $('#updateStockForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            if (!quantityInput.val() || quantityInput.val() <= 0) {
                quantityInput.addClass('is-invalid');
                isValid = false;
            } else {
                quantityInput.removeClass('is-invalid');
            }

            // Check if stock out would result in negative stock
            const quantity = parseInt(quantityInput.val()) || 0;
            const actionType = $('input[name="action_type"]:checked').val();
            
            if (actionType === 'out' && quantity > currentStock) {
                alert('Cannot remove more stock than currently available!');
                isValid = false;
            }
            
            // Check if adjustment would result in negative stock
            if (actionType === 'adjustment' && quantity < 0) {
                alert('Stock level cannot be negative!');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });

        // Remove validation styling on input
        $('input').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        // Initialize preview and labels
        updatePreview();
        updateLabels();
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 