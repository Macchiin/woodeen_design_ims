<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-truck"></i> Edit Supplier
                    </h1>
                    <a href="/wooden_design_ims/suppliers" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Suppliers
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
                            <i class="fas fa-building"></i> Supplier Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/suppliers/update/<?php echo htmlspecialchars($supplier['supplier_id']); ?>" method="POST" id="supplierForm">
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-info-circle"></i> Basic Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplier_name" class="form-label">
                                            <i class="fas fa-building"></i> Supplier Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" 
                                               value="<?php echo htmlspecialchars($supplier['supplier_name']); ?>" 
                                               placeholder="Enter supplier name" required>
                                        <div class="form-text">Enter the complete business name</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_person" class="form-label">
                                            <i class="fas fa-user"></i> Contact Person
                                        </label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" 
                                               value="<?php echo htmlspecialchars($supplier['contact_person']); ?>" 
                                               placeholder="Enter contact person name">
                                        <div class="form-text">Primary contact person for this supplier</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-phone"></i> Contact Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            <i class="fas fa-phone-alt"></i> Phone Number
                                        </label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="<?php echo htmlspecialchars($supplier['phone']); ?>" 
                                               placeholder="Enter phone number">
                                        <div class="form-text">Contact phone number</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i> Email Address
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($supplier['email']); ?>" 
                                               placeholder="Enter email address">
                                        <div class="form-text">Contact email address</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-map-marker-alt"></i> Address Information
                                    </h5>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address" class="form-label">
                                            <i class="fas fa-map"></i> Address
                                        </label>
                                        <textarea class="form-control" id="address" name="address" rows="4" 
                                                  placeholder="Enter complete address..."><?php echo htmlspecialchars($supplier['address']); ?></textarea>
                                        <div class="form-text">Complete business address</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/wooden_design_ims/suppliers" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Supplier
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
        $('#supplierForm').on('submit', function(e) {
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

            // Email validation if provided
            const email = $('#email').val();
            if (email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    $('#email').addClass('is-invalid');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });

        // Remove validation styling on input
        $('input, select, textarea').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>