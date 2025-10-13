<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-trademark"></i> Add New Brand
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

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-plus-circle"></i> Brand Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="/wooden_design_ims/brands/store" method="POST" id="brandForm">
                                    
                                    <!-- Basic Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </h5>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="brand_name" class="form-label">
                                                    <i class="fas fa-tag"></i> Brand Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="brand_name" name="brand_name" 
                                                       value="<?php echo htmlspecialchars(isset($old_data['brand_name']) ? $old_data['brand_name'] : ''); ?>" 
                                                       placeholder="Enter brand name (e.g., ToolMaster, Premium Wood)" required>
                                                <div class="form-text">The official name of the brand</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-chart-line"></i> Brand Status
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </span>
                                                    <input type="text" class="form-control" value="Active" readonly>
                                                </div>
                                                <div class="form-text">New brands are automatically active</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-align-left"></i> Additional Information
                                            </h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description" class="form-label">
                                                    <i class="fas fa-file-text"></i> Description
                                                </label>
                                                <textarea class="form-control" id="description" name="description" rows="4" 
                                                          placeholder="Describe the brand, its specialties, quality standards, or any relevant information..."><?php echo htmlspecialchars(isset($old_data['description']) ? $old_data['description'] : ''); ?></textarea>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle"></i> Optional: Provide details about the brand's characteristics, specialties, or quality standards
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <span id="charCount">0</span> characters (max 500)
                                                    </small>
                                                </div>
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
                                                    <i class="fas fa-save"></i> Create Brand
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
        // Character counter for description
        $('#description').on('input', function() {
            const maxLength = 500;
            const currentLength = $(this).val().length;
            const remaining = maxLength - currentLength;
            
            $('#charCount').text(currentLength);
            
            if (currentLength > maxLength) {
                $(this).val($(this).val().substring(0, maxLength));
                $('#charCount').text(maxLength);
            }
            
            if (remaining < 50) {
                $('#charCount').addClass('text-warning');
            } else {
                $('#charCount').removeClass('text-warning');
            }
        });

        // Form validation
        $('#brandForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            if (!$('#brand_name').val().trim()) {
                $('#brand_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#brand_name').removeClass('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // Remove validation styling on input
        $('input, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        // Auto-focus on brand name
        $('#brand_name').focus();
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>