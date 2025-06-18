<?php
session_start();

// حذف كل بيانات الجلسة
$_SESSION = [];
session_unset();
session_destroy();

// توجيه إلى login.php
header("Location: login.php");
exit;
?>
