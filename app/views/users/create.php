<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-plus"></i> Register New User
                    </h1>
                    <a href="/wooden_design_ims/users" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
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
                                    <i class="fas fa-plus-circle"></i> User Account Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="/wooden_design_ims/users/store" method="POST" id="userForm">
                                    
                                    <!-- Personal Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-user"></i> Personal Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="full_name" class="form-label">
                                                    <i class="fas fa-user-circle"></i> Full Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                                       value="<?php echo htmlspecialchars($old_data['full_name'] ?? ''); ?>" 
                                                       placeholder="Enter full name" required>
                                                <div class="form-text">The complete name of the user</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="staff_id" class="form-label">
                                                    <i class="fas fa-id-badge"></i> Staff ID <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="staff_id" name="staff_id" 
                                                       value="<?php echo htmlspecialchars($old_data['staff_id'] ?? ''); ?>" 
                                                       placeholder="e.g., STAFF001, EMP2024001" required>
                                                <div class="form-text">Unique identifier for the staff member</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Information Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-key"></i> Account Information
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username" class="form-label">
                                                    <i class="fas fa-user-tag"></i> Username <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="username" name="username" 
                                                       value="<?php echo htmlspecialchars($old_data['username'] ?? ''); ?>" 
                                                       placeholder="Enter username (e.g., john.doe, jdoe)" required>
                                                <div class="form-text">Unique username for login (no spaces, lowercase recommended)</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                       value="<?php echo htmlspecialchars($old_data['email'] ?? ''); ?>" 
                                                       placeholder="user@company.com" required>
                                                <div class="form-text">Primary email address for notifications</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Role & Security Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-shield-alt"></i> Role & Security
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role" class="form-label">
                                                    <i class="fas fa-user-shield"></i> User Role <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="staff" <?php echo (isset($old_data['role']) && $old_data['role'] == 'staff') ? 'selected' : ''; ?>>
                                                        <i class="fas fa-user"></i> Staff
                                                    </option>
                                                    <option value="admin" <?php echo (isset($old_data['role']) && $old_data['role'] == 'admin') ? 'selected' : ''; ?>>
                                                        <i class="fas fa-user-cog"></i> Administrator
                                                    </option>
                                                </select>
                                                <div class="form-text">Determines user permissions and access levels</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-chart-line"></i> Account Status
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </span>
                                                    <input type="text" class="form-control" value="Active" readonly>
                                                </div>
                                                <div class="form-text">New accounts are automatically active</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-lock"></i> Password Setup
                                            </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label">
                                                    <i class="fas fa-key"></i> Password <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" name="password" 
                                                           placeholder="Enter password" required>
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="form-text">Minimum 8 characters, include uppercase, lowercase, and numbers</div>
                                                <div class="mt-2">
                                                    <div class="password-strength" id="passwordStrength"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="confirm_password" class="form-label">
                                                    <i class="fas fa-key"></i> Confirm Password <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                           placeholder="Confirm password" required>
                                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="form-text">Re-enter the password to confirm</div>
                                                <div class="mt-2">
                                                    <div id="passwordMatch"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security Tips Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="text-primary mb-3">
                                                <i class="fas fa-lightbulb"></i> Security Guidelines
                                            </h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <h6><i class="fas fa-info-circle"></i> Account Security Tips:</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Strong Password:</strong> Use 8+ characters with mixed case and numbers</li>
                                                            <li><strong>Unique Username:</strong> Avoid common names, use initials or numbers</li>
                                                            <li><strong>Valid Email:</strong> Use company email for professional communication</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul class="mb-0">
                                                            <li><strong>Role Selection:</strong> Choose appropriate access level</li>
                                                            <li><strong>Staff ID:</strong> Use consistent format for easy identification</li>
                                                            <li><strong>Account Security:</strong> Users should change password on first login</li>
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
                                                <a href="/wooden_design_ims/users" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Create User Account
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
        // Password visibility toggle
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#toggleConfirmPassword').click(function() {
            const passwordField = $('#confirm_password');
            const icon = $(this).find('i');
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Password strength checker
        $('#password').on('input', function() {
            const password = $(this).val();
            let strength = 0;
            let feedback = '';

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    feedback = '<span class="text-danger"><i class="fas fa-times"></i> Very Weak</span>';
                    break;
                case 2:
                    feedback = '<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Weak</span>';
                    break;
                case 3:
                    feedback = '<span class="text-info"><i class="fas fa-minus"></i> Fair</span>';
                    break;
                case 4:
                    feedback = '<span class="text-primary"><i class="fas fa-check"></i> Good</span>';
                    break;
                case 5:
                    feedback = '<span class="text-success"><i class="fas fa-check-double"></i> Strong</span>';
                    break;
            }

            $('#passwordStrength').html(feedback);
        });

        // Password match checker
        $('#confirm_password').on('input', function() {
            const password = $('#password').val();
            const confirmPassword = $(this).val();
            
            if (confirmPassword === '') {
                $('#passwordMatch').html('');
            } else if (password === confirmPassword) {
                $('#passwordMatch').html('<span class="text-success"><i class="fas fa-check"></i> Passwords match</span>');
            } else {
                $('#passwordMatch').html('<span class="text-danger"><i class="fas fa-times"></i> Passwords do not match</span>');
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
                $(this).parent().find('.form-text').html('Primary email address for notifications');
            }
        });

        // Username validation
        $('#username').on('input', function() {
            const username = $(this).val();
            if (username.includes(' ')) {
                $(this).val(username.replace(/\s/g, ''));
            }
        });

        // Form validation
        $('#userForm').on('submit', function(e) {
            let isValid = true;
            
            // Check required fields
            const requiredFields = ['full_name', 'staff_id', 'username', 'email', 'role', 'password', 'confirm_password'];
            requiredFields.forEach(field => {
                if (!$(`#${field}`).val().trim()) {
                    $(`#${field}`).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(`#${field}`).removeClass('is-invalid');
                }
            });
            
            // Check password match
            if ($('#password').val() !== $('#confirm_password').val()) {
                $('#confirm_password').addClass('is-invalid');
                isValid = false;
            }
            
            // Check password strength
            const password = $('#password').val();
            if (password.length < 8) {
                $('#password').addClass('is-invalid');
                isValid = false;
            }
            
            // Check email format
            const email = $('#email').val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fix the errors before submitting.');
            }
        });

        // Remove validation styling on input
        $('input, select').on('input change', function() {
            $(this).removeClass('is-invalid');
        });

        // Auto-focus on full name
        $('#full_name').focus();
    });
    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>