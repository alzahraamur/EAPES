<?php
session_start();
require_once 'include/db_config.php';

// التأكد من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = 'pending';
    $evaluation = null; // سيتم التقييم لاحقًا
    $department_id = 0; // إذا لم يكن لديك أقسام محددة، ضعيها 0 أو استخرجيها من جلسة المستخدم
    $created_at = date('Y-m-d H:i:s');

    // إدخال التقرير في قاعدة البيانات
    $stmt = $pdo->prepare("INSERT INTO reports (staff_id, title, content, status, evaluation, department_id, created_at) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$staff_id, $title, $content, $status, $evaluation, $department_id, $created_at])) {
        // تم الحفظ بنجاح، إعادة التوجيه لعرض التقارير
        header("Location: view-reports.php");
        exit;
    } else {
        echo "❌ حدث خطأ أثناء إضافة التقرير.";
    }
} else {
    echo "❌ طريقة الطلب غير صالحة.";
}
?>
