<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <h2>Brand Management</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>

        <?php if (isAdmin()): ?>
            <p><a href="/wooden_design_ims/brands/create" class="button">Add New Brand</a></p>
        <?php endif; ?>

        <?php if (!empty($brands)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <?php if (isAdmin()): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $brand): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($brand['brand_id']); ?></td>
                            <td><?php echo htmlspecialchars($brand['brand_name']); ?></td>
                            <td><?php echo htmlspecialchars($brand['description']); ?></td>
                            <?php if (isAdmin()): ?>
                                <td>
                                    <a href="/wooden_design_ims/brands/edit/<?php echo $brand['brand_id']; ?>" class="button edit">Edit</a>
                                    <form action="/wooden_design_ims/brands/delete/<?php echo $brand['brand_id']; ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this brand? This will fail if products are linked to it.');">
                                        <button type="submit" class="button delete">Delete</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No brands found.</p>
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