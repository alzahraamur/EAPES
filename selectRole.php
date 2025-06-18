<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user info from session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['first_name'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/select-role.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <main class="select-section">
        <div class="select-container">
            <div class="select-form-box">
                <div class="welcome-header">
                    <i class='bx bx-user-circle'></i>
                    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
                    <p>Please select your role to continue</p>
                </div>
                <form id="roleForm" class="select-form" action="process_role.php" method="POST">
                    <div class="role-cards">
                        <div class="role-card" data-role="manager">
                            <i class='bx bx-briefcase'></i>
                            <h3>Manager</h3>
                            <p>Manage departments and oversee performance</p>
                        </div>

                        <div class="role-card" data-role="head_of_section">
                            <i class='bx bx-group'></i>
                            <h3>Head of Department</h3>
                            <p>Lead department and manage team performance</p>
                        </div>

                        <div class="role-card" data-role="staff">
                            <i class='bx bx-user'></i>
                            <h3>Staff</h3>
                            <p>Track achievements and view evaluations</p>
                        </div>
                    </div>

                    <input type="hidden" id="selected_role" name="role" required>

                    <button type="submit" class="btn-submit" disabled>
                        <i class='bx bx-right-arrow-alt'></i>
                        Continue
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="js/select-role.js"></script>
</body>

</html>
