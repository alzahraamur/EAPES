<?php
session_start();
require_once 'include/db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'head_of_section') {
    header('Location: login.php');
    exit;
}

// ✅ جلب department_id الخاص بالـ head_of_section
$stmt = $pdo->prepare("SELECT department_id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$department_id = $stmt->fetchColumn();

// ✅ جلب الإحصائيات
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'staff' AND department_id = ?");
$stmt->execute([$department_id]);
$teamMembers = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ?");
$stmt->execute([$department_id]);
$totalReports = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ? AND status = 'Pending'");
$stmt->execute([$department_id]);
$pendingReports = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM reports WHERE department_id = ? AND status = 'Approved'");
$stmt->execute([$department_id]);
$approvedReports = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT AVG(evaluation_score) FROM reports WHERE department_id = ? AND evaluation_score IS NOT NULL");
$stmt->execute([$department_id]);
$averageEvaluation = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section Performance Analytics</title>
    <link rel="stylesheet" href="css/main.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .analytics-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .analytics-card i {
            font-size: 36px;
            color: #3A6CF4;
            margin-bottom: 10px;
        }
        .analytics-card p {
            font-weight: bold;
            margin: 0;
        }
        .analytics-card h3 {
            margin-top: 5px;
            font-size: 24px;
        }
        .btn-back {
            display: inline-block;
            margin-bottom: 15px;
            color: #3A6CF4;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>

    <main class="main-section">
        <div class="container">
            <a href="section-head-dashboard.php" class="btn-back">← Back to Dashboard</a>
            <h1 class="page-title">Section Performance Analytics</h1>

            <div class="analytics-grid">
                <div class="analytics-card">
                    <i class="bx bx-user"></i>
                    <p>Team Members</p>
                    <h3><?= htmlspecialchars($teamMembers) ?></h3>
                </div>

                <div class="analytics-card">
                    <i class="bx bx-file"></i>
                    <p>Total Reports</p>
                    <h3><?= htmlspecialchars($totalReports) ?></h3>
                </div>

                <div class="analytics-card">
                    <i class="bx bx-time"></i>
                    <p>Pending Reports</p>
                    <h3><?= htmlspecialchars($pendingReports) ?></h3>
                </div>

                <div class="analytics-card">
                    <i class="bx bx-check-circle"></i>
                    <p>Approved Reports</p>
                    <h3><?= htmlspecialchars($approvedReports) ?></h3>
                </div>

                <div class="analytics-card">
                    <i class="bx bx-bar-chart-alt-2"></i>
                    <p>Average Evaluation</p>
                    <h3><?= $averageEvaluation !== null ? round($averageEvaluation, 2) : 'N/A' ?></h3>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
</body>
</html>
