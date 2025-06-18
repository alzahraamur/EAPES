<?php
include 'include/db_config.php';


$newPassword = "12341234Aa";


$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


$email = "admin@example.com";
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hashedPassword, $email]);

echo "✅ Password for $email updated to '12341234Aa'";
?>
