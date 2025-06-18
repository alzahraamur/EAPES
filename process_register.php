<?php
session_start();
require_once 'include/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header('Location: register.php');
        exit;
    }


   
    $stmt = $pdo->prepare("SELECT user_id    FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = "Username already taken";
        header('Location: register.php');
        exit;
    }
   
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute(params: [$username, $password]);
   
    $_SESSION['success'] = "Registration successful! Please login.";
    header('Location: login.php');
    exit;
}
