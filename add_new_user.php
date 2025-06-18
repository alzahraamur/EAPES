<?php
session_start();
include '../include/db_config.php';

// تحقق أن المستخدم مدير
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../login.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($name) && !empty($email) && !empty($password) && !empty($role)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashedPassword, $role])) {
            $message = "✅ User added successfully!";
        } else {
            $message = "❌ Failed to add user.";
        }
    } else {
        $message = "❌ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User - EAT-PES</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 500px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-container h1 {
            text-align: center;
        }
        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #3A6CF4;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #2e56c5;
        }
        .back-btn {
            background-color: #777;
            margin-bottom: 15px;
        }
        .back-btn:hover {
            background-color: #555;
        }
        .message {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php 
$currentPage = 'add-user';
include '../include/navbar.php'; 
?>

<main class="main-section">
    <div class="container">
        <div style="margin-bottom: 15px;">
    <button onclick="history.back()" class="btn btn-secondary" style="background: #ccc; color: #333; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">
        <i class="bx bx-arrow-back"></i> Back
    </button>
</div>

        <div class="form-container">
            <h1>Add New User</h1>
            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="manager">Manager</option>
                    <option value="head_of_section">Head of Section</option>
                    <option value="staff">Staff</option>
                </select>
                <button type="submit">
                    <i class='bx bx-user-plus'></i> Add User
                </button>
            </form>
        </div>
    </div>
</main>

<?php include '../include/footer.php'; ?>
</body>
</html>
