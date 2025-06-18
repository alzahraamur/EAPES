<?php
session_start();
include '../include/db_config.php';

// التأكد أن المستخدم مدير
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: ../login.php");
    exit;
}

$currentPage = 'admin';

// جلب الأقسام
$departments = $pdo->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();

// تحديث بيانات المستخدم
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_role'], $_POST['new_department_id'])) {
    $id = $_POST['user_id'];
    $new_role = $_POST['new_role'];
    $new_department_id = !empty($_POST['new_department_id']) ? $_POST['new_department_id'] : null;

    $stmt = $pdo->prepare("UPDATE users SET role = ?, department_id = ? WHERE id = ?");
    $stmt->execute([$new_role, $new_department_id, $id]);

    header("Location: users_admin.php");
    exit;
}

// جلب المستخدمين مع الأقسام
$users = $pdo->query("
    SELECT u.*, d.name AS department_name 
    FROM users u 
    LEFT JOIN departments d ON u.department_id = d.id 
    ORDER BY u.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - Admin</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
        }
        select {
            padding: 5px;
        }
        .submit-btn {
            background-color: #3A6CF4;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        .submit-btn:hover {
            background-color: #2e56c5;
        }
        .add-user-btn {
            display: inline-block;
            margin-bottom: 10px;
            background-color: #28a745;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 4px;
        }
        .add-user-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<?php include '../include/navbar.php'; ?>

<main class="main-section">
    <div class="container">
        <h1 class="page-title">User Management</h1>

        <!-- زر إضافة مستخدم جديد -->
        <a href="add_new_user.php" class="add-user-btn">
            <i class="bx bx-user-plus"></i> Add New User
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th>Current Department</th>
                    <th>Update Role & Department</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['department_name'] ?? 'N/A') ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <select name="new_role" required>
                                    <option value="manager" <?= $user['role'] === 'manager' ? 'selected' : '' ?>>Manager</option>
                                    <option value="head_of_section" <?= $user['role'] === 'head_of_section' ? 'selected' : '' ?>>Head of Section</option>
                                    <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                                </select>
                                <select name="new_department_id">
                                    <option value="">No Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>" <?= $user['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dept['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="submit-btn">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../include/footer.php'; ?>
</body>
</html>
