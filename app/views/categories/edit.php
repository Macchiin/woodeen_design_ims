<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-folder-open"></i> Edit Category
                    </h1>
                    <a href="/wooden_design_ims/categories" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
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
                            <i class="fas fa-folder"></i> Category Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/categories/update/<?php echo htmlspecialchars($category['category_id']); ?>" method="POST" id="categoryForm">
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-info-circle"></i> Basic Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name" class="form-label">
                                            <i class="fas fa-tag"></i> Category Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" 
                                               value="<?php echo htmlspecialchars($category['category_name']); ?>" 
                                               placeholder="Enter category name" required>
                                        <div class="form-text">Enter a descriptive name for the category</div>
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
                                                  placeholder="Enter category description or additional notes..."><?php echo htmlspecialchars($category['description']); ?></textarea>
                                        <div class="form-text">Optional: Add description or notes about this category</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/wooden_design_ims/categories" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Category
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
        $('#categoryForm').on('submit', function(e) {
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