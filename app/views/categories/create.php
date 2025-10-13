<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-folder-plus"></i> Add New Category
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

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-plus-circle"></i> Category Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="/wooden_design_ims/categories/store" method="POST" id="categoryForm">
                                    
                                    <!-- Basic Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </h5>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="category_name" class="form-label">
                                                    <i class="fas fa-tag"></i> Category Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="category_name" name="category_name" 
                                                       value="<?php echo htmlspecialchars(isset($old_data['category_name']) ? $old_data['category_name'] : ''); ?>" 
                                                       placeholder="Enter category name (e.g., Wood Materials, Hardware, Tools)" required>
                                                <div class="form-text">The name that will be used to group similar products</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-chart-line"></i> Category Status
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </span>
                                                    <input type="text" class="form-control" value="Active" readonly>
                                                </div>
                                                <div class="form-text">New categories are automatically active</div>
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
                                                          placeholder="Describe what types of products belong to this category, any specific characteristics, or usage guidelines..."><?php echo htmlspecialchars(isset($old_data['description']) ? $old_data['description'] : ''); ?></textarea>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle"></i> Optional: Provide details about what products belong to this category
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <span id="charCount">0</span> characters (max 500)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Category Examples Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-lightbulb"></i> Category Examples
                                            </h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6><i class="fas fa-info-circle"></i> Popular Category Examples:</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Wood Materials:</strong> Lumber, plywood, veneer</li>
                                                            <li><strong>Hardware:</strong> Nails, screws, hinges</li>
                                                            <li><strong>Tools:</strong> Hand tools, power tools</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Finishing Materials:</strong> Paints, varnishes</li>
                                                            <li><strong>Packaging:</strong> Boxes, wrapping materials</li>
                                                            <li><strong>Safety Equipment:</strong> Gloves, goggles, masks</li>
                                                        </ul>
                                                    </div>
                                                </div>
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
                                                    <i class="fas fa-save"></i> Create Category
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
        $('#categoryForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            if (!$('#category_name').val().trim()) {
                $('#category_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#category_name').removeClass('is-invalid');
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

        // Auto-focus on category name
        $('#category_name').focus();
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>