<?php
// 1. نظام الحماية والاتصال
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/shopping/include/connected.php';

if (!isset($_SESSION['email'])) {
    header("Location: admin.php"); 
    exit();
}

// 2. معالجة إضافة قسم جديد
if(isset($_POST['add_cat'])){
    $Sectionname = $_POST['Sectionname'];
    
    if(empty($Sectionname)){
        echo "<script>alert('الحقل فارغ الرجاء ملء الحقل');</script>";
    } else {
        try {

            $insert = "INSERT INTO section (Sectionname) VALUES (:name)";
            $stmt = $conn->prepare($insert);
            $stmt->bindParam(':name', $Sectionname);
            
            if($stmt->execute()){
                echo "<script>alert('تمت إضافة القسم بنجاح');</script>";
                echo "<script>window.location.href='adminpanel.php';</script>";
            }
        } catch(PDOException $e) {
            echo "<div class='alert alert-danger'>خطأ في قاعدة البيانات: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الإدارة</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 sidebar">
            <div class="sidebar-header">لوحة تحكم الاداره</div>
            <div class="nav flex-column">
                <a href="adminpanel.php" class="nav-link active">الصفحة الرئيسية <i class="fa fa-home"></i></a>
                <a href="products.php" class="nav-link">صفحة المنتجات <i class="fa fa-tshirt"></i></a>
                <a href="add_product.php" class="nav-link">اضافة منتج <i class="fa fa-plus-square"></i></a>
                <a href="orders.php" class="nav-link">طلبات الزبائن <i class="fa fa-shopping-cart"></i></a>
                <a href="logout.php" class="nav-link text-danger">تسجيل الخروج <i class="fa fa-sign-out-alt"></i></a>
            </div>
        </nav>

        <main class="col-md-9 col-lg-10 main-content">
            <h2 class="mb-4 text-center">إدارة الأقسام</h2>
            
            <div class="card-custom">
                <h5 class="mb-3 text-secondary">اضافة قسم جديد</h5>
                <form action="" method="POST">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <input type="text" name="Sectionname" class="form-control" placeholder="ادخل اسم القسم هنا..." required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="add_cat" class="btn btn-primary w-100">اضافة قسم</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center bg-white shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>الرقم التسلسلي</th>
                            <th>اسم القسم</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // جلب البيانات الحقيقية من قاعدة البيانات
                        $query = $conn->query("SELECT * FROM section");
                        $i = 1; 
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['Sectionname']); ?></td>
                            <td>
                                <a href="delete_cat.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('هل أنت متأكد من حذف هذا القسم نهائياً؟')">
                                    <i class="fa fa-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <p class="text-center mt-5 text-muted">&copy; <?php echo date("Y"); ?> نظام إدارة المتجر</p>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>