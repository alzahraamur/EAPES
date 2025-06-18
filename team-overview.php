<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}

try {
    
    $stats = $pdo->prepare("
        SELECT 
            COUNT(*) as total_employees,
            SUM(CASE WHEN r.status = 'approved' THEN 1 ELSE 0 END) as approved_reports,
            SUM(CASE WHEN r.status = 'pending' THEN 1 ELSE 0 END) as pending_reports
        FROM users u
        LEFT JOIN reports r ON u.user_id = r.staff_id
        WHERE u.role = 'staff'
    ");
    $stats->execute();
    $teamStats = $stats->fetch(PDO::FETCH_ASSOC);

    
    $stmt = $pdo->prepare("SELECT u.user_id, u.username , COUNT(r.report_id) as total_reports
        FROM users u
        LEFT JOIN reports r ON u.user_id = r.staff_id
        WHERE u.role = 'staff'
        GROUP BY u.user_id;");
    $stmt->execute();
    $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    $error = "An error occurred while fetching team data.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Overview - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/team-overview.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $currentPage = 'team';
    include 'include/navbar.php';
    ?>

    <main class="main-section">
        <div class="container">
            <div class="page-header">
                <div class="header-content">
                    <h1>Team Overview</h1>
                    <p class="subtitle">Monitor your team's performance and reports</p>
                </div>
                <div class="header-actions">
                    <a href="manager-dashboard.php" class="btn btn-back">
                        <i class='bx bx-arrow-back'></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="overview-stats">
                <div class="stat-card">
                    <i class='bx bx-group'></i>
                    <div class="stat-info">
                        <h3>Total Team Members</h3>
                        <p><?php echo $teamStats['total_employees']; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-check-circle'></i>
                    <div class="stat-info">
                        <h3>Approved Reports</h3>
                        <p><?php echo $teamStats['approved_reports']; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-time'></i>
                    <div class="stat-info">
                        <h3>Pending Reports</h3>
                        <p><?php echo $teamStats['pending_reports']; ?></p>
                    </div>
                </div>
            </div>

            <div class="team-section">
                <div class="section-header">
                    <h2>Team Members</h2>
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" id="searchMember" placeholder="Search team members...">
                    </div>
                </div>

                <div class="team-grid">
                    <?php foreach ($teamMembers as $member): ?>
                        <div class="member-card">
                            <div class="member-header">
                                <div class="member-avatar">
                                    <i class='bx bxs-user'></i>
                                </div>
                                <div class="member-info">
                                    <h3><?php echo htmlspecialchars($member['username']); ?></h3>
                                    <p class="member-role">Staff Member</p>
                                </div>
                            </div>
                            <div class="member-stats">
                                <div class="stat">
                                    <span class="label">Total Reports</span>
                                    <span class="value"><?php echo $member['total_reports']; ?></span>
                                </div>

                            </div>
                            <div class="member-actions">
                                <a href="view-member.php?id=<?php echo $member['user_id']; ?>" class="btn btn-view">
                                    <i class='bx bx-user'></i>
                                    View Profile
                                </a>
                                <a href="employee-reports.php?staff_id=<?php echo $member['user_id']; ?>"
                                    class="btn btn-reports">
                                    <i class='bx bx-file'></i>
                                    View Reports
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <script src="js/team-overview.js"></script>
</body>

</html>
