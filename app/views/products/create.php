<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus"></i> Add New Product
                    </h1>
                    <a href="/wooden_design_ims/products" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
                        <ul class="mb-0 mt-2">
                            <?php foreach($errors as $err): ?>
                                <li><?php echo htmlspecialchars($err); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-box"></i> Product Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/products/create" method="POST" id="productForm">
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-info-circle"></i> Basic Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name" class="form-label">
                                            <i class="fas fa-tag"></i> Product Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" 
                                               value="<?php echo htmlspecialchars(isset($old_data['product_name']) ? $old_data['product_name'] : ''); ?>" 
                                               placeholder="Enter product name" required>
                                        <div class="form-text">Enter a descriptive name for the product</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_code" class="form-label">
                                            <i class="fas fa-barcode"></i> Product Code <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="product_code" name="product_code" 
                                               value="<?php echo htmlspecialchars(isset($old_data['product_code']) ? $old_data['product_code'] : ''); ?>" 
                                               placeholder="Enter product code" required>
                                        <div class="form-text">Unique identifier for the product</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Classification -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-tags"></i> Classification
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">
                                            <i class="fas fa-folder"></i> Category <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>" 
                                                        <?php echo (isset($old_data['category_id']) && $old_data['category_id'] == $category['category_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Choose the appropriate category</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="brand_id" class="form-label">
                                            <i class="fas fa-trademark"></i> Brand <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="brand_id" name="brand_id" required>
                                            <option value="">Select Brand</option>
                                            <?php foreach ($brands as $brand): ?>
                                                <option value="<?php echo htmlspecialchars($brand['brand_id']); ?>" 
                                                        <?php echo (isset($old_data['brand_id']) && $old_data['brand_id'] == $brand['brand_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($brand['brand_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Select the product brand</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="supplier_id" class="form-label">
                                            <i class="fas fa-truck"></i> Supplier <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                                            <option value="">Select Supplier</option>
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>" 
                                                        <?php echo (isset($old_data['supplier_id']) && $old_data['supplier_id'] == $supplier['supplier_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($supplier['supplier_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="form-text">Choose the product supplier</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-warehouse"></i> Inventory Information
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="current_stock" class="form-label">
                                            <i class="fas fa-boxes"></i> Current Stock <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="current_stock" name="current_stock" 
                                               min="0" value="<?php echo htmlspecialchars(isset($old_data['current_stock']) ? $old_data['current_stock'] : 0); ?>" 
                                               placeholder="0" required>
                                        <div class="form-text">Current quantity in stock</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unit_price" class="form-label">
                                            <i class="fas fa-dollar-sign"></i> Unit Price <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="unit_price" name="unit_price" 
                                                   step="0.01" min="0.01" value="<?php echo htmlspecialchars(isset($old_data['unit_price']) ? $old_data['unit_price'] : '0.00'); ?>" 
                                                   placeholder="0.00" required>
                                        </div>
                                        <div class="form-text">Price per unit</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reorder_level" class="form-label">
                                            <i class="fas fa-exclamation-triangle"></i> Reorder Level <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" 
                                               min="0" value="<?php echo htmlspecialchars(isset($old_data['reorder_level']) ? $old_data['reorder_level'] : 10); ?>" 
                                               placeholder="10" required>
                                        <div class="form-text">Minimum stock level before reorder alert</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-align-left"></i> Additional Information
                                    </h5>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">
                                            <i class="fas fa-file-alt"></i> Description
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="4" 
                                                  placeholder="Enter product description, specifications, or additional notes..."><?php echo htmlspecialchars(isset($old_data['description']) ? $old_data['description'] : ''); ?></textarea>
                                        <div class="form-text">Optional: Add product description, specifications, or notes</div>
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
                                            <i class="fas fa-save"></i> Add Product
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
        // Auto-generate product code if empty
        $('#product_name').on('blur', function() {
            if ($('#product_code').val() === '') {
                const productName = $(this).val();
                if (productName) {
                    const code = productName.replace(/[^A-Z0-9]/gi, '').substring(0, 8).toUpperCase();
                    $('#product_code').val(code);
                }
            }
        });

        // Form validation
        $('#productForm').on('submit', function(e) {
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

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // Remove validation styling on input
        $('input, select').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>