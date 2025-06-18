<?php
session_start();
require_once 'include/db_config.php';

// التحقق من الجلسة والصلاحية
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'head_of_section') {
    header('Location: login.php');
    exit;
}

// جلب موظفي القسم
$stmt = $pdo->prepare("SELECT id, name FROM users WHERE role = 'staff' AND department_id = (SELECT department_id FROM users WHERE id = ?)");
$stmt->execute([$_SESSION['user_id']]);
$staffList = $stmt->fetchAll();

// معالجة الإرسال
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_POST['staff_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($staff_id && $title && $content) {
        $stmt = $pdo->prepare("INSERT INTO reports (staff_id, title, content, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
        if ($stmt->execute([$staff_id, $title, $content])) {
            $success = '✅ Report successfully added.';
        } else {
            $error = '❌ Failed to add report.';
        }
    } else {
        $error = '❌ All fields are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Report - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/contact.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
<?php
$currentPage = 'reports';
include 'include/navbar.php';
?>

<main class="main-section">
    <div class="container">
        <h1 class="page-title">Create New Report</h1>
        <p class="subtitle">Generate a report for your team member</p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="contact-form" style="max-width: 600px; margin: auto;">
            <div class="input-group">
                <label for="staff_id">Select Staff</label>
                <select name="staff_id" id="staff_id" required>
                    <option value="">-- Select Staff --</option>
                    <?php foreach ($staffList as $staff): ?>
                        <option value="<?= $staff['id'] ?>"><?= htmlspecialchars($staff['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <label for="title">Report Title</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="input-group">
                <label for="content">Report Content</label>
                <textarea name="content" id="content" rows="5" required></textarea>
            </div>

            <div class="form-actions" style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-plus-circle"></i> Submit Report
                </button>
                <button type="button" class="btn btn-secondary" onclick="history.back()">
                    <i class="bx bx-arrow-back"></i> Back
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bx bx-reset"></i> Reset
                </button>
            </div>
        </form>
    </div>
</main>

<?php include 'include/footer.php'; ?>
</body>

</html>
