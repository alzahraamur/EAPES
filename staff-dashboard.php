<?php
session_start();
require_once 'include/db_config.php';

// Check if user is logged in and is a staff member
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}

// Fetch staff member's information
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$staff = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/staff-dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $currentPage = 'dashboard';
    include 'include/navbar.php';
    ?>

    <main class="main-section">
        <div class="container">
            <div class="dashboard-header">
                <h1>Welcome, <?php echo htmlspecialchars($staff['name']); ?>!</h1>
                <p class="subtitle">Track your progress and achievements</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="dashboard-stats">
                <div class="stat-card">
                    <i class='bx bx-file'></i>
                    <div class="stat-info">
                        <h3>Recent Reports</h3>
                        <?php
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE staff_id = ?");
                        $stmt->execute([$_SESSION['user_id']]);
                        $recentReports = $stmt->fetchColumn();
                        ?>
                        <p><?php echo $recentReports; ?></p>
                    </div>
                </div>
            </div>

            <div class="dashboard-actions">
                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-file-find'></i>
                    </div>
                    <h3>View Reports</h3>
                    <p>Access your performance reports and evaluations</p>
                    <a href="view-reports.php" class="btn btn-primary">
                        <i class='bx bx-show'></i> View Reports
                    </a>
                </div>

                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-plus-circle'></i>
                    </div>
                    <h3>Add Progress</h3>
                    <p>Update your achievements and milestones</p>
                    <a href="add-progress.php" class="btn btn-primary">
                        <i class='bx bx-plus'></i> Add Progress
                    </a>
                </div>

                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-chart'></i>
                    </div>
                    <h3>View Evaluation</h3>
                    <p>Check your performance evaluation results</p>
                    <a href="view-evaluation.php" class="btn btn-primary">
                        <i class='bx bx-bar-chart-alt-2'></i> View Evaluation
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <script src="js/staff-dashboard.js"></script>
</body>
</html>
