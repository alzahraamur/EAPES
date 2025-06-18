<?php
session_start();
require_once 'include/db_config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate required fields
    // $required_fields = ['title', 'employee_id', 'period', 'date', 'description'];
    // foreach ($required_fields as $field) {
    //     if (!isset($_POST[$field]) || empty($_POST[$field])) {
    //         throw new Exception("All fields are required");
    //     }
    // }

    print_r($_POST);
    // Sanitize and validate inputs
    // $title = trim($_POST['title']);
    // $employee_id = (int) $_POST['employee_id'];
    // $period = $_POST['period'];
    // $evaluation_date = $_POST['date'];
    // $description = trim($_POST['description']);
    // $ratings = $_POST['ratings'];

}

// // Calculate overall rating
// $overall_rating = array_sum($ratings) / count($ratings);

// // Determine grade based on overall rating
// $grade = '';
// if ($overall_rating >= 4.5) {
//     $grade = 'Excellent';
// } elseif ($overall_rating >= 3.5) {
//     $grade = 'Good';
// } elseif ($overall_rating >= 2.5) {
//     $grade = 'Satisfactory';
// } else {
//     $grade = 'Needs Improvement';
// }

// // Start transaction
// $pdo->beginTransaction();

// // Insert report
// $stmt = $pdo->prepare("
//         INSERT INTO reports (
//             title,
//             employee_id,
//             manager_id,
//             evaluation_period,
//             evaluation_date,
//             description,
//             overall_rating,
//             grade,
//             created_at
//         ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
//     ");

// $stmt->execute([
//     $title,
//     $employee_id,
//     $_SESSION['user_id'],
//     $period,
//     $evaluation_date,
//     $description,
//     $overall_rating,
//     $grade
// ]);

// $report_id = $pdo->lastInsertId();

// // Insert individual ratings
// $stmt = $pdo->prepare("
//         INSERT INTO report_ratings (
//             report_id,
//             category,
//             rating
//         ) VALUES (?, ?, ?)
//     ");

// foreach ($ratings as $category => $rating) {
//     $stmt->execute([$report_id, $category, $rating]);
// }

// // Commit transaction
// $pdo->commit();

// $_SESSION['success'] = "Report added successfully!";
// header('Location: Add-report.php');
// exit;





header('Location: Add-report.php');
exit;
