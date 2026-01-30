<?php
include('include/connected.php'); 
session_start();

if (isset($_POST['add_to_cart'])) {

    if(!isset($_SESSION['user_id'])){
        echo "<script>
            alert('يرجى تسجيل الدخول أولاً لإضافة المنتجات للسلة');
            window.location.href='user/login.php';
        </script>";
        exit();
    }

    // استلام البيانات من النموذج ومن الجلسة
    $user_id = $_SESSION['user_id']; // الحصول على معرف المستخدم المسجل
    $p_name = $_POST['h_name'];
    $p_price = $_POST['h_price'];
    $p_image = $_POST['h_image'];
    $p_qty = $_POST['quantity'];

    $check = $conn->prepare("SELECT * FROM cart WHERE name = ? AND user_id = ?");
    $check->execute([$p_name, $user_id]);
    
    if ($check->rowCount() > 0) {
        echo "<script>alert('هذا المنتج موجود بالفعل في سلتك الشخصية'); window.location.href='index.php';</script>";
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, name, price, image, quantity) VALUES (?, ?, ?, ?, ?)");
        if ($insert->execute([$user_id, $p_name, $p_price, $p_image, $p_qty])) {
            echo "<script>alert('تمت إضافة المنتج بنجاح إلى سلتك'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('حدث خطأ في الإضافة');</script>";
        }
    }
}
?>