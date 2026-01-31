<?php
// تضمين ملف الاتصال - تأكد أن ملف connected.php يستخدم PDO
include ('../include/connected.php');

$message = "";
$type = "";

// التأكد من الضغط على زر الإضافة
if(isset($_POST['add_btn'])){
    try {
        // 1. استلام البيانات من النموذج  
        $product_name      = $_POST['product_name'];
        $product_price     = $_POST['product_price'];
        $product_section   = $_POST['product_section'];
        $product_desc      = $_POST['product_desc'];
        $product_size      = $_POST['product_size'];
        $product_available = $_POST['product_available'];

        // 2. معالجة الصورة
        $imageName = $_FILES['product_image']['name'];
        $imageTmp  = $_FILES['product_image']['tmp_name'];

        // التحقق من أن الحقول ليست فارغة
        if(empty($product_name) || empty($product_price) || empty($imageName)){
            $message = "الرجاء ملء جميع الحقول الأساسية!";
            $type = "warning";
        } else {
            // 3. تجهيز اسم الصورة وتحديد المسار
            $product_image = rand(0, 5000) . "_" . $imageName;
            $upload_path = "../uploads/img/" . $product_image;

            // 4. استعلام الإدخال باستخدام PDO (الطريقة الآمنة)
            $sql = "INSERT INTO product (product_name, product_price, product_image, product_section, product_desc, product_size, product_available) 
                    VALUES (:product_name, :product_price, :product_image, :product_section, :product_desc, :product_size, :product_available)";
            
            $preper_sql = $conn->prepare($sql);

            // 5. ربط المتغيرات بالبيانات
            $data = [
                ':product_name'      => $product_name,
                ':product_price'     => $product_price,
                ':product_image'     => $product_image,
                ':product_section'   => $product_section,
                ':product_desc'      => $product_desc,
                ':product_size'      => $product_size,
                ':product_available' => $product_available,
            ];

            // 6. التنفيذ النهائي ورفع الصورة
            if($preper_sql->execute($data)){
                if(move_uploaded_file($imageTmp, $upload_path)){
                    $message = "تمت إضافة المنتج بنجاح!";
                    $type = "success";
                } else {
                    $message = "تم حفظ البيانات ولكن فشل رفع الصورة، تأكد من تصاريح المجلد.";
                    $type = "warning";
                }
            }
        }
    } catch(PDOException $e) {
        $message = "فشل الإدخال: " . $e->getMessage();
        $type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 form-container border p-4 bg-white shadow-sm rounded">
            <h2 class="text-center mb-4 text-primary">إضافة منتج جديد</h2>
            
            <?php if($message != ""): ?>
                <div class="alert alert-<?php echo $type; ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo $message; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان المنتج</label>
                        <input type="text" name="product_name" class="form-control" placeholder="أدخل اسم المنتج" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">سعر المنتج</label>
                        <input type="number" name="product_price" class="form-control" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">صورة المنتج</label>
                    <input type="file" name="product_image" class="form-control" accept="image/*" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">القسم</label>
                        <select name="product_section" class="form-select">
                            <option value="ملابس">ملابس</option>
                            <option value="أحذية">أحذية</option>
                            <option value="اكسسوارات">اكسسوارات</option>
                             <option value="إلكترونيات">إلكترونيات</option>
                            <option value="عطور">عطور</option>



                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">المقاسات المتوفرة</label>
                        <input type="text" name="product_size" class="form-control" placeholder="S, M, L, XL">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">تفاصيل المنتج</label>
                    <textarea name="product_desc" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">توفر المنتج</label>
                    <select name="product_available" class="form-select">
                        <option value="متوفر">متوفر</option>
                        <option value="غير متوفر">غير متوفر</option>
                    </select>
                </div>

                <button type="submit" name="add_btn" class="btn btn-primary w-100 py-2 mt-3">إضافة المنتج الآن</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>