<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-truck"></i> Add New Supplier
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

                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-plus-circle"></i> Supplier Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="/wooden_design_ims/suppliers/store" method="POST" id="supplierForm">
                                    
                                    <!-- Basic Information Section -->
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
                                                       value="<?php echo htmlspecialchars(isset($old_data['supplier_name']) ? $old_data['supplier_name'] : ''); ?>" 
                                                       placeholder="Enter supplier company name" required>
                                                <div class="form-text">The official name of the supplier company</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_person" class="form-label">
                                                    <i class="fas fa-user"></i> Contact Person
                                                </label>
                                                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                                                       value="<?php echo htmlspecialchars(isset($old_data['contact_person']) ? $old_data['contact_person'] : ''); ?>" 
                                                       placeholder="Primary contact person name">
                                                <div class="form-text">Main contact person for this supplier</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-address-book"></i> Contact Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope"></i> Email Address
                                                </label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                       value="<?php echo htmlspecialchars(isset($old_data['email']) ? $old_data['email'] : ''); ?>" 
                                                       placeholder="supplier@example.com">
                                                <div class="form-text">Primary email address for communications</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">
                                                    <i class="fas fa-phone"></i> Phone Number
                                                </label>
                                                <input type="tel" class="form-control" id="phone" name="phone" 
                                                       value="<?php echo htmlspecialchars(isset($old_data['phone']) ? $old_data['phone'] : ''); ?>" 
                                                       placeholder="+1 (555) 123-4567">
                                                <div class="form-text">Primary phone number for contact</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Information Section -->
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
                                                          placeholder="Enter complete address including street, city, state/province, postal code, and country..."><?php echo htmlspecialchars(isset($old_data['address']) ? $old_data['address'] : ''); ?></textarea>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle"></i> Complete address for shipping and billing purposes
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <span id="charCount">0</span> characters (max 500)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-lightbulb"></i> Additional Information
                                            </h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6><i class="fas fa-info-circle"></i> Supplier Information Tips:</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Supplier Name:</strong> Use official company name</li>
                                                            <li><strong>Contact Person:</strong> Primary contact for orders</li>
                                                            <li><strong>Email:</strong> For order confirmations and invoices</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Phone:</strong> For urgent communications</li>
                                                            <li><strong>Address:</strong> For shipping and billing</li>
                                                            <li><strong>Accuracy:</strong> Ensure all details are current</li>
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
                                                <a href="/wooden_design_ims/suppliers" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Create Supplier
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
        // Character counter for address
        $('#address').on('input', function() {
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

        // Email validation
        $('#email').on('blur', function() {
            const email = $(this).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                $(this).addClass('is-invalid');
                $(this).parent().find('.form-text').html('<div class="text-danger">Please enter a valid email address</div>');
            } else {
                $(this).removeClass('is-invalid');
                $(this).parent().find('.form-text').html('Primary email address for communications');
            }
        });

        // Phone number formatting
        $('#phone').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = `(${value}`;
                } else if (value.length <= 6) {
                    value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
                } else {
                    value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6, 10)}`;
                }
            }
            $(this).val(value);
        });

        // Form validation
        $('#supplierForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            if (!$('#supplier_name').val().trim()) {
                $('#supplier_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#supplier_name').removeClass('is-invalid');
            }
            
            // Check email format if provided
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
                alert('Please fix the errors before submitting.');
            }
        });

        // Remove validation styling on input
        $('input, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        // Auto-focus on supplier name
        $('#supplier_name').focus();
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>