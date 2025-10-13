<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-trademark"></i> Edit Brand
                    </h1>
                    <a href="/wooden_design_ims/brands" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Brands
                    </a>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-trademark"></i> Brand Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/brands/update/<?php echo htmlspecialchars($brand['brand_id']); ?>" method="POST" id="brandForm">
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-info-circle"></i> Basic Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand_name" class="form-label">
                                            <i class="fas fa-tag"></i> Brand Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="brand_name" name="brand_name" 
                                               value="<?php echo htmlspecialchars($brand['brand_name']); ?>" 
                                               placeholder="Enter brand name" required>
                                        <div class="form-text">Enter the brand name</div>
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
                                                  placeholder="Enter brand description or additional notes..."><?php echo htmlspecialchars($brand['description']); ?></textarea>
                                        <div class="form-text">Optional: Add description or notes about this brand</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/wooden_design_ims/brands" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Brand
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
        // Form validation
        $('#brandForm').on('submit', function(e) {
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
        $('input, textarea').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>