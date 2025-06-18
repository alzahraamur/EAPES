<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'head_of_section') {
    header('Location: login.php');
    exit;
}


$stmt = $pdo->prepare("
    SELECT r.*, u.name AS staff_name
    FROM reports r
    JOIN users u ON r.staff_id = u.id
    ORDER BY r.created_at DESC
");
$stmt->execute();
$reports = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Reports - EAT-PES</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            background: #fff;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background: #3A6CF4;
            color: white;
        }

        .btn-view {
            background-color: #3A6CF4;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-view:hover {
            background-color: #2e56c5;
        }
    </style>
</head>
<body>

<h1>Employee Reports</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Staff Name</th>
            <th>Title</th>
            <th>Status</th>
            <th>Submitted On</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($reports): ?>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['report_id']) ?></td>
                    <td><?= htmlspecialchars($report['staff_name']) ?></td>
                    <td><?= htmlspecialchars($report['title']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($report['status'])) ?></td>
                    <td><?= date('d M Y', strtotime($report['created_at'])) ?></td>
                    <td>
                        <a href="employee-report.php?id=<?= $report['report_id'] ?>" class="btn-view">
                            <i class='bx bx-show'></i> View
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No reports found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
