<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-edit"></i> Edit Order #<?php echo htmlspecialchars($order['order_id']); ?>
                    </h1>
                    <a href="/wooden_design_ims/orders" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Orders
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

                <form action="/wooden_design_ims/orders/edit/<?php echo $order['order_id']; ?>" method="POST" id="orderForm">
                    <div class="row">
                        <!-- Order Details -->
                        <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-info-circle"></i> Order Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="supplier_id" class="form-label">
                                            <i class="fas fa-truck"></i> Supplier <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>" 
                                                        <?php echo ($order['supplier_id'] == $supplier['supplier_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="order_date" class="form-label">
                                            <i class="fas fa-calendar"></i> Order Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="order_date" name="order_date" 
                                               value="<?php echo htmlspecialchars($order['order_date']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="expected_delivery_date" class="form-label">
                                            <i class="fas fa-calendar-check"></i> Expected Delivery Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="expected_delivery_date" name="expected_delivery_date" 
                                               value="<?php echo htmlspecialchars($order['expected_delivery_date']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">
                                            <i class="fas fa-tasks"></i> Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="delivered" <?php echo ($order['status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            <i class="fas fa-sticky-note"></i> Notes
                                        </label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                  placeholder="Enter any additional notes..."><?php echo htmlspecialchars($order['notes'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-list"></i> Order Items
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="orderItems">
                                        <?php foreach ($orderItems as $index => $item): ?>
                                            <div class="row mb-3 order-item">
                                                <div class="col-md-4">
                                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                                    <select class="form-select product-select" name="items[<?php echo $index; ?>][product_id]" required>
                                                        <option value="">Select Product</option>
                                                        <?php foreach ($products as $product): ?>
                                                            <option value="<?php echo htmlspecialchars($product['product_id']); ?>" 
                                                                    data-price="<?php echo $product['unit_price']; ?>"
                                                                    data-stock="<?php echo $product['current_stock']; ?>"
                                                                    <?php echo ($item['product_id'] == $product['product_id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($product['product_name']); ?> (<?php echo htmlspecialchars($product['product_code']); ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control quantity-input" name="items[<?php echo $index; ?>][quantity]" 
                                                           value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">
                                                        <i class="fas fa-dollar-sign"></i> Unit Price <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control price-input" name="items[<?php echo $index; ?>][unit_price]" 
                                                               value="<?php echo htmlspecialchars($item['unit_price']); ?>" step="0.01" min="0.01" required>
                                                    </div>
                                                    <div class="form-text">Price per unit</div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">
                                                        <i class="fas fa-calculator"></i> Total
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control total-input" value="<?php echo number_format($item['total_price'], 2); ?>" readonly>
                                                    </div>
                                                    <div class="form-text">Item total</div>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>
                                    </div>



                                    <hr class="my-4">

                                    <div class="row">
                                        <div class="col-md-6 offset-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0">Total Amount:</h5>
                                                        <h4 class="mb-0 text-success" id="orderTotal">$<?php echo number_format($order['total_amount'], 2); ?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="/wooden_design_ims/orders" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Order
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        let itemIndex = <?php echo count($orderItems); ?>;



        // Calculate item total
        function calculateItemTotal(item) {
            const quantity = parseFloat(item.find('.quantity-input').val()) || 0;
            const price = parseFloat(item.find('.price-input').val()) || 0;
            const total = quantity * price;
            item.find('.total-input').val(total.toFixed(2));
            return total;
        }

        // Calculate order total
        function calculateTotal() {
            let total = 0;
            $('.order-item').each(function() {
                total += calculateItemTotal($(this));
            });
            $('#orderTotal').text('$' + total.toFixed(2));
        }

        // Auto-fill price when product is selected
        $(document).on('change', '.product-select', function() {
            const selectedOption = $(this).find('option:selected');
            const price = selectedOption.data('price');
            const stock = selectedOption.data('stock');
            const productName = selectedOption.text();
            
            const item = $(this).closest('.order-item');
            const priceInput = item.find('.price-input');
            
            if (price && price > 0) {
                // Auto-populate the price
                priceInput.val(price);
                
                // Add visual feedback
                priceInput.addClass('border-success');
                setTimeout(() => {
                    priceInput.removeClass('border-success');
                }, 2000);
                
                // Show success message
                const successMsg = $(`<small class="text-success"><i class="fas fa-check"></i> Unit price auto-populated from inventory</small>`);
                priceInput.parent().parent().find('.form-text').html(successMsg);
                
                // Update quantity max if stock is available
                if (stock !== undefined) {
                    item.find('.quantity-input').attr('max', stock);
                    item.find('.quantity-input').attr('placeholder', `Max: ${stock} units`);
                }
                
                console.log(`Auto-populated price for ${productName}: $${price}`);
            } else {
                // Clear the price if no product selected or price is 0
                priceInput.val('');
                priceInput.removeClass('border-success');
                item.find('.quantity-input').removeAttr('max');
                item.find('.quantity-input').attr('placeholder', 'Enter quantity');
                priceInput.parent().parent().find('.form-text').html('<div class="form-text">Price per unit</div>');
            }
            
            calculateItemTotal(item);
            calculateTotal();
        });

        // Recalculate when quantity or price changes
        $(document).on('input', '.quantity-input, .price-input', function() {
            calculateItemTotal($(this).closest('.order-item'));
            calculateTotal();
            
            // Remove auto-populated styling when user manually changes price
            if ($(this).hasClass('price-input')) {
                $(this).removeClass('border-success');
                $(this).parent().parent().find('.form-text').html('<div class="form-text">Price per unit</div>');
            }
        });

        // Form validation
        $('#orderForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            $('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Check if at least one item has product selected
            let hasItems = false;
            $('.product-select').each(function() {
                if ($(this).val()) {
                    hasItems = true;
                }
            });

            if (!hasItems) {
                alert('Please select at least one product for the order.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // Remove validation styling on input
        $('input, select').on('input change', function() {
            $(this).removeClass('is-invalid');
        });

        // Initialize totals
        calculateTotal();
        
        // Initialize auto-fetching for existing items
        $('.product-select').each(function() {
            if ($(this).val()) {
                $(this).trigger('change');
            }
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 