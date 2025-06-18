<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}


try {
    $stmt = $pdo->prepare("
        SELECT r.*, 
               u.first_name, 
               u.last_name,
               u.department_id
        FROM reports r
        JOIN users u ON r.employee_id = u.id
        WHERE r.manager_id = ?
        ORDER BY r.created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching reports: " . $e->getMessage());
    $error = "An error occurred while fetching reports.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Reports - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/employee-report.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $currentPage = 'reports';
    include 'include/navbar.php';
    ?>

    <main class="main-section">
        <div class="container">
            <div class="page-header">
                <h1>Employee Reports</h1>
                <div class="header-actions">
                    <a href="add-report.php" class="btn btn-primary">
                        <i class='bx bx-plus'></i> New Report
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="reports-filter">
                <input type="text" id="searchInput" placeholder="Search reports...">
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="reports-grid">
                <?php foreach ($reports as $report): ?>
                    <div class="report-card" data-status="<?php echo $report['status']; ?>">
                        <div class="report-header">
                            <h3><?php echo htmlspecialchars($report['first_name'] . ' ' . $report['last_name']); ?></h3>
                            <span class="status-badge <?php echo $report['status']; ?>">
                                <?php echo ucfirst($report['status']); ?>
                            </span>
                        </div>

                        <div class="report-summary">
                            <p><strong>Grade:</strong> <?php echo $report['evaluation_grade']; ?></p>
                            <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($report['report_date'])); ?></p>
                        </div>

                        <div class="report-actions">
                            <button class="btn btn-view" onclick="viewReport(<?php echo $report['id']; ?>)">
                                <i class='bx bx-show'></i> View
                            </button>
                            <button class="btn btn-edit" onclick="editReport(<?php echo $report['id']; ?>)">
                                <i class='bx bx-edit'></i> Edit
                            </button>
                            <?php if ($report['status'] === 'pending'): ?>
                                <button class="btn btn-approve" onclick="approveReport(<?php echo $report['id']; ?>)">
                                    <i class='bx bx-check'></i> Approve
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

  
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="reportContent"></div>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>
    <script src="js/employee-report.js"></script>
</body>

</html>
