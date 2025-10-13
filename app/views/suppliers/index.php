<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <h2>Supplier Management</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>

        <?php if (isAdmin()): ?>
            <p><a href="/wooden_design_ims/suppliers/create" class="button">Add New Supplier</a></p>
        <?php endif; ?>

        <?php if (!empty($suppliers)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <?php if (isAdmin()): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $supplier): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($supplier['supplier_id']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['supplier_name']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['contact_person']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($supplier['address'])); ?></td>
                            <?php if (isAdmin()): ?>
                                <td>
                                    <a href="/wooden_design_ims/suppliers/edit/<?php echo $supplier['supplier_id']; ?>" class="button edit">Edit</a>
                                    <form action="/wooden_design_ims/suppliers/delete/<?php echo $supplier['supplier_id']; ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this supplier? This will fail if transactions are linked to them.');">
                                        <button type="submit" class="button delete">Delete</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No suppliers found.</p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <style>
        /* Basic table and button styles (can be moved to style.css) */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { display: inline-block; padding: 8px 12px; margin-right: 5px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .button.edit { background-color: #ffc107; }
        .button.delete { background-color: #dc3545; }
        .button.cancel { background-color: #6c757d; }
        .button:hover { opacity: 0.9; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea,
        .form-group select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</body>
</html>