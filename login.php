<?php
session_start();
session_unset();
session_destroy();
session_start();

include 'include/db_config.php';
$currentPage = 'login';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'manager') {
            header("Location: admin/users_admin.php");
        } elseif ($user['role'] === 'head_of_section') {
            header("Location: section-head-dashboard.php");
        } else {
            header("Location: staff-dashboard.php");
        }
        exit;
    } else {
        $error = "❌ Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <main class="main-section">
        <div class="container">
            <div class="login-container">
                <div class="login-image">
                    <img src="images/Login-pana.svg" alt="Login Illustration">
                </div>
                <div class="form-box login">
                    <h1>Welcome Back</h1>
                    <p class="subtitle">Please login to your account</p>
                    <?php if ($error): ?>
                        <div style="color:red; font-weight:bold; margin-bottom:10px;">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="input-box">
                            <input type="email" name="email" id="email" required>
                            <label for="email">Email</label>
                            <i class="bx bxs-user"></i>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" id="password" required>
                            <label for="password">Password</label>
                            <i class="bx bx-lock-alt"></i>
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                                <i class="bx bx-show"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <span>Login</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <div class="register-option">
                            <p>Don't have an account? <a href="register.php">Create New Account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include 'include/footer.php'; ?>
    <script src="js/login.js"></script>
</body>

</html>
