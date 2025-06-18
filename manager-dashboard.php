<?php
session_start();
require_once 'include/db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}



$stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$manager = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/manager-dashboard.css">
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
                <h1>Welcome, <?php echo htmlspecialchars($manager['username']); ?>!</h1>
                <p class="subtitle">Manage your team's performance and reports</p>
            </div>

            <div class="dashboard-stats">
                <div class="stat-card">
                    <i class='bx bx-user'></i>
                    <div class="stat-info">
                        <h3>Total Employees</h3>
                        <?php
                        $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'employee'");
                        $employeeCount = $stmt->fetchColumn();
                        ?>
                        <p><?php echo $employeeCount; ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class='bx bx-file'></i>
                    <div class="stat-info">
                        <h3>Pending Reports</h3>
                        <?php
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM evaluations ");
                        $stmt->execute();
                        $pendingReports = $stmt->fetchColumn();
                        ?>
                        <p><?php echo $pendingReports; ?></p>
                    </div>
                </div>


            </div>

            <div class="dashboard-actions">
                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-file-find'></i>
                    </div>
                    <h3>View Reports</h3>
                    <p>Access and review employee performance reports</p>
                    <a href="employee-reports.php" class="btn btn-primary">View Reports</a>
                </div>

                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-plus-circle'></i>
                    </div>
                    <h3>Add Report</h3>
                    <p>Create new performance evaluation reports</p>
                    <a href="add-report.php" class="btn btn-primary">Create Report</a>
                </div>

                <div class="action-card">
                    <div class="action-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <h3>Team Overview</h3>
                    <p>View team performance metrics and analytics</p>
                    <a href="team-overview.php" class="btn btn-primary">View Team</a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
</body>

</html>
