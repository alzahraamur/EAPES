<?php
session_start();
require_once 'include/db_config.php';

// تأكد من تسجيل الدخول وأن المستخدم head_of_section
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'head_of_section') {
    header('Location: login.php');
    exit;
}

// جلب بيانات الـ head
$stmt = $pdo->prepare("SELECT name, department_id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$head = $stmt->fetch();

// جلب اسم القسم
$dept_name = '';
if ($head && $head['department_id']) {
    $stmt = $pdo->prepare("SELECT name FROM departments WHERE id = ?");
    $stmt->execute([$head['department_id']]);
    $dept = $stmt->fetch();
    $dept_name = $dept ? $dept['name'] : 'N/A';
}

// إحصائيات القسم
// عدد الموظفين
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'staff' AND department_id = ?");
$stmt->execute([$head['department_id']]);
$staff_count = $stmt->fetchColumn();

// عدد التقارير المضافة
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ?");
$stmt->execute([$head['department_id']]);
$total_reports = $stmt->fetchColumn();

// عدد التقارير المعلقة
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ? AND status = 'pending'");
$stmt->execute([$head['department_id']]);
$pending_reports = $stmt->fetchColumn();

// عدد التقارير المقيمة
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ? AND status = 'evaluated'");
$stmt->execute([$head['department_id']]);
$evaluated_reports = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section Head Dashboard - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/section-head-dashboard.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php
$currentPage = 'dashboard';
include 'include/navbar.php';
?>
<main class="main-section">
    <div class="container">
        <div class="dashboard-header">
            <h1>Welcome, <?= htmlspecialchars($head['name']) ?>!</h1>
            <p class="subtitle">Department: <?= htmlspecialchars($dept_name) ?></p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <i class='bx bx-user'></i>
                <div class="stat-info">
                    <h3>Team Members</h3>
                    <p><?= $staff_count ?></p>
                </div>
            </div>
            <div class="stat-card">
                <i class='bx bx-file'></i>
                <div class="stat-info">
                    <h3>Total Reports</h3>
                    <p><?= $total_reports ?></p>
                </div>
            </div>
            <div class="stat-card">
                <i class='bx bx-time'></i>
                <div class="stat-info">
                    <h3>Pending Reports</h3>
                    <p><?= $pending_reports ?></p>
                </div>
            </div>
            <div class="stat-card">
                <i class='bx bx-check-circle'></i>
                <div class="stat-info">
                    <h3>Evaluated Reports</h3>
                    <p><?= $evaluated_reports ?></p>
                </div>
            </div>
        </div>

        <div class="dashboard-actions">
            <div class="action-card">
                <div class="action-icon">
                    <i class='bx bx-file-find'></i>
                </div>
                <h3>View Reports</h3>
                <p>Access and review team reports</p>
                <a href="employee-reports.php" class="btn btn-primary">View Reports</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class='bx bx-plus-circle'></i>
                </div>
                <h3>Create Evaluation</h3>
                <p>Evaluate team members</p>
                <a href="add-report.php" class="btn btn-primary">Create Evaluation</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class='bx bx-bar-chart-alt-2'></i>
                </div>
                <h3>Performance Analytics</h3>
                <p>View section analytics</p>
                <a href="analytics.php" class="btn btn-primary">View Analytics</a>
            </div>
        </div>
    </div>
</main>

<?php include 'include/footer.php'; ?>
</body>
</html>
