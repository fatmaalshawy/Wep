<?php
// ابدأ الجلسة للتحقق من الأمان
session_start();

// ربط ملف الاتصال الذي نجح معك سابقاً
include $_SERVER['DOCUMENT_ROOT'] . '/shopping/include/connected.php';

// حماية الصفحة: لا يدخل إلا الأدمن المسجل
if (!isset($_SESSION['email'])) {
    header("Location: admin.php"); 
    exit();
}

// استلام رقم القسم (ID) من الرابط (المصفوفة $_GET)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM product WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // إظهار رسالة نجاح ثم العودة للوحة التحكم
            echo "<script>alert('تم حذف القسم بنجاح');</script>";
            echo "<script>window.location.href='adminpanel.php';</script>";
        }
    } catch (PDOException $e) {
        // في حال وجود مشكلة في قاعدة البيانات
        echo "خطأ أثناء محاولة الحذف: " . $e->getMessage();
    }
} else {
    // إذا حاول شخص دخول احة بدون رقم ID، أعده للوحة التحكم
    header("Location: adminpanel.php");
    exit();
}
?>