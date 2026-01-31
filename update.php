<?php 
// 1. تضمين ملف الاتصال
include('../include/connected.php'); 

// 2. جلب بيانات المنتج المراد تعديله لعرضها في الحقول
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
}

// 3. معالجة التعديل عند الضغط على زر الحفظ
if(isset($_POST['update_btn'])){
    // ملاحظة: تأكدنا أن الأسماء هنا تطابق الـ name في فورم الـ HTML بالأسفل
    $name = $_POST['product_name']; 
    $price = $_POST['product_price'];
    $id_edit = $_POST['id_hidden'];

    $sql = "UPDATE product SET product_name=?, product_price=? WHERE id=?";
    $up_stmt = $conn->prepare($sql);
    
    // تنفيذ التعديل وإذا نجح نقوم بالتحويل فوراً
    if($up_stmt->execute([$name, $price, $id_edit])){
        // استخدام الهيدر للانتقال لصفحة المنتجات بعد النجاح
        header("Location: products.php"); 
        exit(); // إنهاء السكريبت لضمان عدم حدوث أخطاء تحذيرية
    } else {
        echo "<script>alert('فشل في تحديث المنتج');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h3 class="text-center mb-4 text-primary">تعديل بيانات المنتج</h3>
                    <form method="POST">
                        <input type="hidden" name="id_hidden" value="<?php echo @$row['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">اسم المنتج</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo @$row['product_name']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">السعر</label>
                            <input type="text" name="product_price" class="form-control" value="<?php echo @$row['product_price']; ?>" required>
                        </div>
                        
                        <button type="submit" name="update_btn" class="btn btn-success w-100 fw-bold py-2">
                            <i class="fas fa-save me-1"></i> حفظ التعديلات والعودة
                        </button>
                        
                        <a href="products.php" class="btn btn-outline-secondary w-100 mt-2">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>