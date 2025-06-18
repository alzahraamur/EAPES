<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

try {
   
    $stmt = $pdo->prepare("
        SELECT report_id, title, status, evaluation, evaluator_comment, evaluation_score, created_at, content
        FROM reports
        WHERE staff_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = "An error occurred while fetching evaluations.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Evaluation - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/view-evaluation.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #3A6CF4;
            color: white;
        }
    </style>
</head>
<body>
<?php
$currentPage = 'evaluation';
include 'include/navbar.php';
?>

<main class="main-section">
    <div class="container">

    <div style="margin-bottom: 15px;">
    <button onclick="history.back()" class="btn btn-secondary" style="background: #ccc; color: #333; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">
        <i class="bx bx-arrow-back"></i> Back
    </button>
</div>

        <h1 class="page-title">My Evaluations</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php elseif (empty($reports)): ?>
            <div class="alert alert-info">No evaluations available yet.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Evaluation</th>
                        <th>Score</th>
                        <th>Comment</th>
                        <th>Created At</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= htmlspecialchars($report['title']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($report['status'])) ?></td>
                            <td><?= htmlspecialchars($report['evaluation']) ?: 'N/A' ?></td>
                            <td><?= htmlspecialchars($report['evaluation_score']) ?: 'N/A' ?></td>
                            <td><?= nl2br(htmlspecialchars($report['evaluator_comment'])) ?: 'N/A' ?></td>
                            <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                        
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include 'include/footer.php'; ?>
</body>
</html>
