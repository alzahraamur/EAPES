<?php
session_start();
require_once 'include/db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'head_of_section') {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id = $_POST['report_id'];

    if (isset($_POST['approve'])) {
        $stmt = $pdo->prepare("UPDATE reports SET status = 'approved' WHERE report_id = ?");
        $stmt->execute([$report_id]);
        $message = "✅ Report approved successfully.";
    }

    if (isset($_POST['reject'])) {
        $stmt = $pdo->prepare("UPDATE reports SET status = 'rejected' WHERE report_id = ?");
        $stmt->execute([$report_id]);
        $message = "❌ Report rejected.";
    }

    if (isset($_POST['save_evaluation'])) {
        $evaluation = $_POST['evaluation'];
        $comment = $_POST['evaluator_comment'];
        $score = $_POST['evaluation_score'];

        $stmt = $pdo->prepare("UPDATE reports SET evaluation = ?, evaluator_comment = ?, evaluation_score = ? WHERE report_id = ?");
        $stmt->execute([$evaluation, $comment, $score, $report_id]);
        $message = "💾 Evaluation saved successfully.";
    }
}

$stmt = $pdo->query("SELECT * FROM reports ORDER BY created_at DESC");
$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Reports - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <style>
        .message {
            padding: 10px;
            background-color: #e7f3fe;
            border: 1px solid #2196F3;
            color: #0b75c9;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .report-card {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background: #fff;
        }
        .report-footer button {
            background-color: #3A6CF4;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            margin-right: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 120px;
        }
        .report-footer button:hover {
            background-color: #2e56c5;
        }
        .read-more-btn {
            color: #3A6CF4;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-back {
            display: inline-block;
            margin-bottom: 15px;
            color: #3A6CF4;
            text-decoration: none;
            font-weight: bold;
        }
        header {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        header .logo img {
            height: 50px;
        }
        .navigation a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            margin-left: 15px;
        }
        .navigation a:hover {
            color: #3A6CF4;
        }
    </style>
</head>
<body>

<header>
    <a href="section-head-dashboard.php" class="logo">
        <img src="images/Black_White_Bold_Modern_Studio_Logo-removebg-preview.png" alt="EAT-PES Logo">
    </a>
    <nav class="navigation">
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main class="main-section">
    <div class="container">
        <a href="section-head-dashboard.php" class="btn-back">← Back to Dashboard</a>
        <h1 class="page-title">Employee Reports</h1>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php foreach ($reports as $report): ?>
            <div class="report-card">
                <div class="report-header">
                    <h3><?= htmlspecialchars($report['title']) ?></h3>
                    <span class="status"><?= ucfirst($report['status']) ?></span>
                </div>

                <p class="short-content"><?= nl2br(htmlspecialchars(substr($report['content'], 0, 100))) ?>...</p>
                <p class="full-content" style="display:none;"><?= nl2br(htmlspecialchars($report['content'])) ?></p>
                <button class="read-more-btn" onclick="toggleContent(this)">Read More</button>

                <form method="POST" style="margin-top:15px;">
                    <input type="hidden" name="report_id" value="<?= $report['report_id'] ?>">
                    <label>Evaluation:</label>
                    <input type="text" name="evaluation" value="<?= htmlspecialchars($report['evaluation'] ?? '') ?>">
                    <label>Comment:</label>
                    <textarea name="evaluator_comment"><?= htmlspecialchars($report['evaluator_comment'] ?? '') ?></textarea>
                    <label>Score:</label>
                    <input type="number" name="evaluation_score" value="<?= htmlspecialchars($report['evaluation_score'] ?? '') ?>" min="0" max="100">

                    <div class="report-footer">
                        <button type="submit" name="approve">Approve</button>
                        <button type="submit" name="reject">Reject</button>
                        <button type="submit" name="save_evaluation">Save Evalu</button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
function toggleContent(button) {
    const shortContent = button.parentElement.querySelector(".short-content");
    const fullContent = button.parentElement.querySelector(".full-content");
    if (fullContent.style.display === "none" || fullContent.style.display === "") {
        fullContent.style.display = "block";
        shortContent.style.display = "none";
        button.textContent = "Show Less";
    } else {
        fullContent.style.display = "none";
        shortContent.style.display = "block";
        button.textContent = "Read More";
    }
}
</script>

</body>
</html>
