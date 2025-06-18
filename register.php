<?php
session_start();
include 'include/db_config.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $requested_role = $_POST['role'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($requested_role)) {
        $error_message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address.';
    } elseif ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $error_message = 'Email is already registered.';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user with pending_approval role
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, requested_role) VALUES (?, ?, ?, 'pending_approval', ?)");
            if ($stmt->execute([$name, $email, $hashed_password, $requested_role])) {
                $success_message = '✅ Registration successful! Waiting for manager approval.';
            } else {
                $error_message = 'An error occurred. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php
$currentPage = 'register';
include 'include/navbar.php';
?>
<main class="main-section">
    <div class="container">
        <div class="register-container">
            <div class="register-image">
                <img src="images/Sign up-amico.svg" alt="Registration Illustration">
            </div>
            <div class="form-box register">
                <h1>Create Account</h1>
                <p class="subtitle">Join us to track and celebrate achievements</p>

                <?php if ($error_message): ?>
                    <div class="alert alert-error"><?= $error_message ?></div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success" style="color:green;"><?= $success_message ?></div>
                <?php endif; ?>

                <form method="POST" id="registerForm">
                    <div class="input-box">
                        <input type="text" name="name" id="name" required>
                        <label for="name">Name</label>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" id="email" required>
                        <label for="email">Email</label>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Password</label>
                        <i class="bx bx-lock-alt"></i>
                        <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                            <i class="bx bx-show"></i>
                        </button>
                    </div>
                    <div class="input-box">
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <label for="confirm_password">Confirm Password</label>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <select name="role" id="role" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="manager">Manager</option>
                            <option value="head_of_section">Head of Section</option>
                            <option value="staff">Staff</option>
                        </select>
                        <label for="role" style="top:-20px;">Role</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span>Create Account</span>
                        <i class="bx bx-user-plus"></i>
                    </button>
                    <div class="login-option">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include 'include/footer.php'; ?>
<script src="js/register.js"></script>
</body>
</html>
