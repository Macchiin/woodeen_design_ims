<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="container">
        <h2>Category Management</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>

        <?php if (isAdmin()): ?>
            <p><a href="/wooden_design_ims/categories/create" class="button">Add New Category</a></p>
        <?php endif; ?>

        <?php if (!empty($categories)): ?>
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
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                            <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($category['description']); ?></td>
                            <?php if (isAdmin()): ?>
                                <td>
                                    <a href="/wooden_design_ims/categories/edit/<?php echo $category['category_id']; ?>" class="button edit">Edit</a>
                                    <form action="/wooden_design_ims/categories/delete/<?php echo $category['category_id']; ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        <button type="submit" class="button delete">Delete</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No categories found.</p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { display: inline-block; padding: 8px 12px; margin-right: 5px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .button.edit { background-color: #ffc107; }
        .button.delete { background-color: #dc3545; }
        .button:hover { opacity: 0.9; }
    </style>
</body>
</html>