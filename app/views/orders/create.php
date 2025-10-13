<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-plus"></i> Create New Order
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

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Order Information
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="/wooden_design_ims/orders/create" id="orderForm">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id" class="form-label">
                                        <i class="fas fa-truck"></i> Supplier <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="supplier_id" name="supplier_id" required>
                                        <option value="">Select Supplier</option>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <option value="<?= $supplier['supplier_id'] ?>">
                                                <?= htmlspecialchars($supplier['supplier_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">Choose the supplier for this order</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_date" class="form-label">
                                        <i class="fas fa-calendar"></i> Order Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="order_date" name="order_date" 
                                           value="<?= date('Y-m-d') ?>" required>
                                    <div class="form-text">Date when the order was placed</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected_delivery_date" class="form-label">
                                        <i class="fas fa-calendar-check"></i> Expected Delivery Date
                                    </label>
                                    <input type="date" class="form-control" id="expected_delivery_date" 
                                           name="expected_delivery_date">
                                    <div class="form-text">Expected delivery date from supplier</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note"></i> Notes
                                    </label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                                              placeholder="Additional notes about this order..."></textarea>
                                    <div class="form-text">Optional notes about the order</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3">
                            <i class="fas fa-list"></i> Order Items
                        </h5>
                        <div id="orderItems">
                            <div class="order-item row mb-3" data-item="0">
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <i class="fas fa-box"></i> Product <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select product-select" name="items[0][product_id]" required>
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= $product['product_id'] ?>" 
                                                    data-price="<?= $product['unit_price'] ?>"
                                                    data-stock="<?= $product['current_stock'] ?>">
                                                <?= htmlspecialchars($product['product_name']) ?> 
                                                (<?= htmlspecialchars($product['product_code']) ?>)
                                                - $<?= number_format($product['unit_price'], 2) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">Choose the product to order</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <i class="fas fa-sort-numeric-up"></i> Quantity <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control quantity-input" 
                                           name="items[0][quantity]" min="1" required>
                                    <div class="form-text">Order quantity</div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-block remove-item w-100">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success mb-4" id="addItem">
                            <i class="fas fa-plus"></i> Add Item
                        </button>



                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/wooden_design_ims/orders" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Order
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

<script>
$(document).ready(function() {
    let itemCount = 1;
    


    // Add new item
    $('#addItem').click(function() {
        const newItem = $('.order-item:first').clone();
        newItem.attr('data-item', itemCount);
        newItem.find('select, input').each(function() {
            const name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('[0]', '[' + itemCount + ']'));
            }
        });
        newItem.find('select, input').val('');
        $('#orderItems').append(newItem);
        itemCount++;
    });

    // Remove item
    $(document).on('click', '.remove-item', function() {
        if ($('.order-item').length > 1) {
            $(this).closest('.order-item').remove();
        } else {
            alert('At least one item is required.');
        }
    });

    // Product selection change - update stock limits
    $(document).on('change', '.product-select', function() {
        const selectedOption = $(this).find('option:selected');
        const stock = selectedOption.data('stock');
        const productName = selectedOption.text();
        
        const item = $(this).closest('.order-item');
        

        
        // Update quantity max if stock is available
        if (stock !== undefined) {
            item.find('.quantity-input').attr('max', stock);
            item.find('.quantity-input').attr('placeholder', `Max: ${stock} units`);
        } else {
            item.find('.quantity-input').removeAttr('max');
            item.find('.quantity-input').attr('placeholder', 'Enter quantity');
        }
    });

    // Form validation
    $('#orderForm').submit(function(e) {
        let valid = true;
        
        // Check if at least one item is added
        $('.order-item').each(function() {
            const product = $(this).find('.product-select').val();
            const quantity = $(this).find('.quantity-input').val();
            
            if (product && quantity) {
                // Item is complete
            } else if (product || quantity) {
                // Item is incomplete
                valid = false;
                alert('Please complete all fields for each order item.');
                return false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
        }
    });
    

});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?> 