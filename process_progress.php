<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = 'pending';
    $evaluation = null; 
    $department_id = 0; 
    $created_at = date('Y-m-d H:i:s');

    
    $stmt = $pdo->prepare("INSERT INTO reports (staff_id, title, content, status, evaluation, department_id, created_at) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$staff_id, $title, $content, $status, $evaluation, $department_id, $created_at])) {
        
        header("Location: view-reports.php");
        exit;
    } else {
        echo "❌ An error occurred while adding the report.";
    }
} else {
    echo "❌ The request method is invalid.";
}
?>
