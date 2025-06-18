<?php
require_once 'include/db_config.php';

if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT r.*, u.name AS staff_name FROM reports r 
                           JOIN users u ON r.staff_id = u.id 
                           WHERE r.report_id = ?");
    $stmt->execute([$report_id]);
    $report = $stmt->fetch();

    if ($report) {
        echo "<h2>" . htmlspecialchars($report['title']) . "</h2>";
        echo "<p><strong>By:</strong> " . htmlspecialchars($report['staff_name']) . "</p>";
        echo "<p><strong>Status:</strong> " . htmlspecialchars($report['status']) . "</p>";
        echo "<p><strong>Content:</strong><br>" . nl2br(htmlspecialchars($report['content'])) . "</p>";
    } else {
        echo "<p style='color:red; font-weight:bold;'>❌ Report not found.</p>";
    }
} else {
    echo "<p style='color:red; font-weight:bold;'>❌ Invalid request.</p>";
}
?>
