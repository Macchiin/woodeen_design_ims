<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-users"></i> User Management
                    </h1>
                    <a href="/wooden_design_ims/users/create" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Register New User
                    </a>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($users) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Administrators</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $adminCount = 0;
                                            foreach ($users as $user) {
                                                if ($user['role'] == 'admin') $adminCount++;
                                            }
                                            echo $adminCount;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Staff Members</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                            $staffCount = 0;
                                            foreach ($users as $user) {
                                                if ($user['role'] == 'staff') $staffCount++;
                                            }
                                            echo $staffCount;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <?php if (!empty($users)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> User Accounts
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="usersTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>User Info</th>
                                        <th>Staff ID</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">#<?= $user['user_id'] ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3">
                                                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= htmlspecialchars($user['full_name']) ?></div>
                                                        <small class="text-muted">@<?= htmlspecialchars($user['username']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <?= htmlspecialchars($user['staff_id']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($user['role'] == 'admin'): ?>
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-user-shield"></i> Administrator
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-user-tie"></i> Staff
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="text-decoration-none">
                                                    <i class="fas fa-envelope"></i> <?= htmlspecialchars($user['email']) ?>
                                                </a>
                                            </td>

                                            <td>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar"></i>
                                                    <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/wooden_design_ims/users/edit/<?= $user['user_id'] ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit User">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Delete User"
                                                                onclick="confirmDelete(<?= $user['user_id'] ?>, '<?= htmlspecialchars($user['full_name']) ?>')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-secondary" 
                                                                title="Cannot delete yourself"
                                                                disabled>
                                                            <i class="fas fa-lock"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Users Found</h4>
                        <p class="text-muted mb-4">Get started by registering your first user account.</p>
                        <a href="/wooden_design_ims/users/create" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Register First User
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-danger"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the user <strong id="userName"></strong>?</p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#usersTable').DataTable({
            "order": [[0, "asc"]], // Sort by ID ascending
            "pageLength": 25,
            "language": {
                "search": "Search users:",
                "lengthMenu": "Show _MENU_ users per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ users"
            },
            "columnDefs": [
                { "orderable": false, "targets": 6 } // Disable sorting on Actions column
            ]
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });

    // Delete confirmation
    function confirmDelete(userId, userName) {
        $('#userName').text(userName);
        $('#deleteForm').attr('action', '/wooden_design_ims/users/delete/' + userId);
        $('#deleteModal').modal('show');
    }


    </script>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
