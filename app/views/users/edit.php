<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-edit"></i> Edit User Account
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

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user"></i> User Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="/wooden_design_ims/users/update/<?php echo htmlspecialchars($user['user_id']); ?>" method="POST" id="userForm">
                            <!-- Personal Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-user-circle"></i> Personal Information
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name" class="form-label">
                                            <i class="fas fa-user"></i> Full Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" 
                                               value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" 
                                               placeholder="Enter full name" required>
                                        <div class="form-text">Enter the user's complete name</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="staff_id" class="form-label">
                                            <i class="fas fa-id-badge"></i> Staff ID <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="staff_id" name="staff_id" 
                                               value="<?php echo htmlspecialchars($user['staff_id'] ?? ''); ?>" 
                                               placeholder="Enter staff ID" required>
                                        <div class="form-text">Unique staff identification number</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
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
                                               value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" 
                                               placeholder="Enter username" required>
                                        <div class="form-text">Unique login username</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                                               placeholder="Enter email address" required>
                                        <div class="form-text">Valid email address for notifications</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Role and Security -->
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
                                            <option value="staff" <?php echo ($user['role'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                            <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                        <div class="form-text">Select appropriate access level</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            <i class="fas fa-lock"></i> New Password
                                        </label>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Enter new password (optional)">
                                        <div class="form-text">Leave blank to keep current password</div>
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
                                            <i class="fas fa-save"></i> Update User
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
        $('#userForm').on('submit', function(e) {
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

            // Email validation
            const email = $('#email').val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
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