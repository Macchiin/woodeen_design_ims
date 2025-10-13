<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Woodeen Design</title>
    <link rel="stylesheet" href="/wooden_design_ims/public/assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <div class="logo">
                <i class="fas fa-tree"></i>
            </div>
            <h1 class="brand-name">Woodeen Design</h1>
            <p class="tagline">Inventory Management System</p>
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="/wooden_design_ims/login" method="POST">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <p>&copy; 2024 Woodeen Design. All rights reserved.</p>
        </div>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            position: relative;
        }

        /* Logo Section */
        .logo-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .logo {
            font-size: 48px;
            margin-bottom: 15px;
            color: #f39c12;
        }

        .brand-name {
            font-size: 28px;
            font-weight: 300;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }

        .tagline {
            font-size: 14px;
            opacity: 0.8;
            font-weight: 300;
        }

        /* Login Form */
        .login-form {
            padding: 40px 30px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger {
            background-color: #fee;
            color: #c53030;
            border: 1px solid #fed7d7;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f7fafc;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #a0aec0;
        }

        button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        /* Footer */
        .login-footer {
            background-color: #f7fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer p {
            color: #718096;
            font-size: 12px;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
                border-radius: 15px;
            }

            .logo-section {
                padding: 30px 20px;
            }

            .login-form {
                padding: 30px 20px;
            }

            .brand-name {
                font-size: 24px;
            }

            .logo {
                font-size: 40px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</body>
</html>