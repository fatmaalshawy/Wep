<?php
// 1. بدء الجلسة في أول سطر في الملف ضروري جداً
session_start(); 

// 2. تضمين ملف الاتصال
include ('../include/connected.php');

// 3. معالجة البيانات عند إرسال الفورم
if(isset($_POST['add'])){
    $ADemail    = $_POST['email'];
    $ADpassword = $_POST['password'];

    if(empty($ADemail) || empty($ADpassword)){
        echo '<script>alert("الرجاء إدخال البريد الإلكتروني وكلمة المرور");</script>';
    } else {
        try {
            $query = "SELECT * FROM admin WHERE email = :email AND password = :pass";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':email' => $ADemail,
                ':pass'  => $ADpassword
            ]);

            if($stmt->rowCount() == 1){
                // --- الجزء المدمج الجديد ---
                $_SESSION['email'] = $ADemail; // حفظ إيميل المستخدم في الجلسة
                // --------------------------
                
                echo '<script>alert("مرحباً بك! سيتم تحويلك إلى لوحة التحكم");</script>';
                echo '<script>window.location.href = "adminpanel.php";</script>';
                exit(); // إيقاف السكريبت بعد التحويل
            } else {
                echo '<script>alert("خطأ: البريد الإلكتروني أو كلمة المرور غير صحيحة");</script>';
            }

        } catch (PDOException $e) {
            echo "خطأ في القاعدة: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { margin-top: 100px; }
    </style>
</head>
<body>

<main class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 text-primary">تسجيل الدخول</h3>
                    
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">الرقم السري</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                        </div>

                        <button type="submit" name="add" class="btn btn-primary w-100 py-2">
                            دخول لوحة التحكم
                        </button>
                    </form>
                </div>
            </div>
<p class="text-center mt-3 text-muted">
    &copy; <?php echo date("Y"); ?> نظام إدارة المتجر
</p>        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>