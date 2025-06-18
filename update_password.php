<?php
include 'include/db_config.php';

// كلمة المرور الجديدة (غير مشفّرة)
$newPassword = "12341234Aa";

// تشفيرها
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// تحديث المستخدم المطلوب
$email = "admin@example.com";
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hashedPassword, $email]);

echo "✅ Password for $email updated to '12341234Aa'";
?>
