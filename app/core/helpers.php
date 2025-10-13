<?php
// app/core/helpers.php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function redirectToLogin() {
    header('Location: /wooden_design_ims/login');
    exit();
}

function redirectToDashboard() {
    header('Location: /wooden_design_ims/dashboard');
    exit();
}

function requireAuth() {
    if (!isLoggedIn()) {
        redirectToLogin();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        // For unauthorized access, you might show a 403 page or redirect to dashboard
        header('Location: /wooden_design_ims/dashboard?error=unauthorized');
        exit();
    }
}