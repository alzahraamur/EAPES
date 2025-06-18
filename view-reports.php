<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
  
    $stmt = $pdo->prepare("
        SELECT r.*, u.name
        FROM reports r
        JOIN users u ON r.staff_id = u.id
        WHERE r.staff_id = ?
        ORDER BY r.report_id DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = 'An error occurred while fetching reports.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reports - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/view-reports.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php
$currentPage = 'reports';
include 'include/navbar.php';
?>

<main class="main-section">
    <div class="container">

    <div style="margin-bottom: 15px;">
    <button onclick="history.back()" class="btn btn-secondary" style="background: #ccc; color: #333; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">
        <i class="bx bx-arrow-back"></i> Back
    </button>
</div>

        
        <div class="header-actions">
    <div class="search-box" style="display: inline-flex; align-items: center; margin-right: 10px;">
        <i class="bx bx-search" style="margin-right: 5px;"></i>
        <input type="text" id="searchReport" placeholder="Search reports..." style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <select id="statusFilter" class="filter-select" style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="">All Status</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
</div>


       
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="bx bx-error-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

       
        <div class="reports-container">
            <?php if (empty($reports)): ?>
                <div class="no-reports">
                    <i class="bx bx-file-blank"></i>
                    <h3>No Reports Found</h3>
                    <p>There are no reports available yet.</p>
                </div>
            <?php else: ?>
                <div class="reports-grid">
                    <?php foreach ($reports as $report): ?>
                        <div class="report-card" data-status="<?= $report['status']; ?>">
                            <div class="report-header">
                                <div class="report-title">
                                    <h3><?= htmlspecialchars($report['title']); ?></h3>
                                    <span class="created-at"><?= date('d M Y', strtotime($report['created_at'])) ?></span>
                                </div>
                                <span class="status <?= $report['status']; ?>">
                                    <i class="bx bx-check-circle"></i>
                                    <?= ucfirst($report['status']); ?>
                                </span>
                            </div>

                            <div class="report-preview">
                                <span class="short-content">
                                    <?= nl2br(htmlspecialchars(substr($report['content'], 0, 150))); ?>...
                                </span>
                                <span class="full-content" style="display:none;">
                                    <?= nl2br(htmlspecialchars($report['content'])); ?>
                                </span>
                            </div>

                            <div class="report-footer">
                                <button class="btn btn-toggle" onclick="toggleContent(this)">
                                    Read More
                                </button>
                                <?php if ($report['status'] === 'evaluated'): ?>
                                    <span class="evaluation">Evaluation: <?= htmlspecialchars($report['evaluation']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<div id="reportModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="reportContent"></div>
    </div>
</div>

<script src="js/view-reports.js"></script>
<script>
function toggleContent(button) {
    const card = button.closest('.report-card');
    const shortContent = card.querySelector('.short-content');
    const fullContent = card.querySelector('.full-content');

    if (fullContent.style.display === "none" || fullContent.style.display === "") {
        fullContent.style.display = "inline";
        shortContent.style.display = "none";
        button.textContent = "Show Less";
    } else {
        fullContent.style.display = "none";
        shortContent.style.display = "inline";
        button.textContent = "Read More";
    }
}
</script>
</body>
</html>
