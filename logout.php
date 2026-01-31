<?php
session_start();      // 1. بدء الجلسة
session_unset();      // 2. حذف بيانات الجلسة المخزنة في المتصفح
session_destroy();    // 3. تحطيم الجلسة بالكامل

// 4. إعادة توجيه المستخدم لصفحة تسجيل الدخول
header("Location: admin.php");
exit();
?>
