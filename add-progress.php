<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Progress - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/add-progress.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $currentPage = 'add-progress';
    include 'include/navbar.php';
    ?>

    <main class="main-section">
        <div class="container">

            <div class="progress-form-container">
                <h1>Add Achievement / Progress</h1>
                <p class="subtitle">Record your latest achievement or progress</p>

                <form action="process_progress.php" method="POST" id="progressForm">
                    <div class="form-group">
                        <label for="title">Achievement Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Description</label>
                        <textarea id="content" name="content" rows="4" required></textarea>
                    </div>

                    <input type="hidden" name="staff_id" value="<?= $_SESSION['user_id'] ?>">

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="history.back()">
                            <i class='bx bx-arrow-back'></i> Back
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-plus-circle'></i> Submit Achievement
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class='bx bx-reset'></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <script src="js/add-progress.js"></script>
</body>

</html>
