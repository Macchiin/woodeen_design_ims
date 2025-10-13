<?php
// public/index.php

// Start PHP session for user authentication
session_start();

// Debug: Add this temporarily to see session state
if (isset($_GET['debug'])) {
    echo "<h3>Debug Information:</h3>";
    echo "<p>Session ID: " . session_id() . "</p>";
    echo "<p>Session Data: " . print_r($_SESSION, true) . "</p>";
    echo "<p>isLoggedIn(): " . (isLoggedIn() ? 'true' : 'false') . "</p>";
    echo "<p>REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "</p>";
    echo "<p>GET _url: " . ($_GET['_url'] ?? 'not set') . "</p>";
    echo "<hr>";
}

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        'app/core/',
        'app/models/',
        'app/controllers/'
    ];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Include helper functions
require_once __DIR__ . '/../app/core/helpers.php';

// Include Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// --- URL Parsing Logic ---

// Handle both clean URLs (_url parameter) and old-style URLs (action parameter)
if (isset($_GET['_url'])) {
    $cleanPath = $_GET['_url'];
} elseif (isset($_GET['action'])) {
    $cleanPath = $_GET['action'];
    if (isset($_GET['method'])) {
        $cleanPath .= '/' . $_GET['method'];
    }
    if (isset($_GET['id'])) {
        $cleanPath .= '/' . $_GET['id'];
    }
} else {
    $cleanPath = '';
}

$cleanPath = trim($cleanPath, '/');
$uriSegments = explode('/', $cleanPath);

// Initialize default controller and method
$controllerName = 'AuthController';
$methodName = 'login';
$params = [];

// Determine controller, method, and parameters based on URI segments
if (empty($uriSegments[0])) {
    // If no segment is provided (e.g., http://localhost/wooden_design_ims/)
    if (isLoggedIn()) {
        $controllerName = 'DashboardController';
        $methodName = 'index';
    } else {
        $controllerName = 'AuthController';
        $methodName = 'login';
    }
} elseif ($uriSegments[0] === 'login') {
    // Explicitly route '/login' to AuthController::login
    $controllerName = 'AuthController';
    $methodName = 'login';
    $params = array_slice($uriSegments, 1);
} elseif ($uriSegments[0] === 'logout') {
    // Explicitly route '/logout' to AuthController::logout
    $controllerName = 'AuthController';
    $methodName = 'logout';
    $params = array_slice($uriSegments, 1);
} elseif ($uriSegments[0] === 'clear-session') {
    // Debug route to clear session
    session_unset();
    session_destroy();
    header('Location: /wooden_design_ims/');
    exit();
} elseif ($uriSegments[0] === 'dashboard') {
    $controllerName = 'DashboardController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'users') {
    $controllerName = 'UserController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'products') {
    $controllerName = 'ProductController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'categories') {
    $controllerName = 'CategoryController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'brands') {
    $controllerName = 'BrandController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'suppliers') {
    $controllerName = 'SupplierController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} elseif ($uriSegments[0] === 'orders') {
    $controllerName = 'OrderController';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
} else {
    // Fallback: Dynamically determine controller name
    $controllerName = ucfirst($uriSegments[0]) . 'Controller';
    $methodName = !empty($uriSegments[1]) ? $uriSegments[1] : 'index';
    $params = array_slice($uriSegments, 2);
}

// Construct the full path to the controller file
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

// --- Controller Dispatching ---
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>404 Not Found</h1>";
            echo "<p>The requested method <strong>" . htmlspecialchars($methodName) . "</strong> was not found in controller <strong>" . htmlspecialchars($controllerName) . "</strong>.</p>";
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "<p>The controller class <strong>" . htmlspecialchars($controllerName) . "</strong> was not found.</p>";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "<p>The controller file <strong>" . htmlspecialchars($controllerFile) . "</strong> does not exist.</p>";
}