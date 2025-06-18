<?php
session_start();
require_once 'include/db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $user_id = $_SESSION['user_id'];
    echo "<pre>";
    print_r($_POST);
    echo "<pre>";
    print_r($_SESSION);

    // Validate role
    $valid_roles = ['manager', 'head_of_section', 'staff'];
    if (!in_array($role, $valid_roles)) {
        $_SESSION['error'] = "Invalid role selected";
        header('Location: selectRole.php');
        exit;
    }

    // Update user's role in database
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE user_id = ?");
    $stmt->execute([$role, $user_id]);

    // Update session role
    $_SESSION['role'] = $role;

    // Redirect based on role
    switch ($role) {
        case 'manager':
            header('Location: manager-dashboard.php');
            break;
        case 'head_of_section':
            header('Location: section-head-dashboard.php');
            break;
        case 'staff':
            header('Location: staff-dashboard.php');
            break;
        default:
            header('Location: selectRole.php');
    }

} else {
    // If not POST request, redirect to selection page
    header('Location: selectRole.php');
    exit;
}