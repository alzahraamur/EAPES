<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'include/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'manager') {
                header("Location: admin/users_admin.php");
                exit;
            } elseif ($user['role'] === 'head_of_section') {
                header("Location: head-dashboard.php");
                exit;
            } else {
                header("Location: staff-dashboard.php");
                exit;
            }
        } else {
            echo "<p style='color:red'>❌ Password is incorrect.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Email not found.</p>";
    }
} else {
    echo "<p style='color:red'>❌ The request is invalid.</p>";
}
?>
