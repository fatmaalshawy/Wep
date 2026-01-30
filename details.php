<?php 
// 1. تضمين ملف الاتصال والهيدر وتفعيل الجلسة
include('include/connected.php'); 
include('file/header.php'); 
// ملاحظة: تأكدي أن session_start(); موجودة في أول سطر في ملف header.php أو أضيفيها هنا

// 2. جلب ID المنتج من الرابط عبر GET
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // 3. استعلام لجلب بيانات المنتج المختار من الجدول
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    
    // التحقق إذا كان المنتج موجود فعلاً
    if(!$product){
        echo "<div class='alert alert-danger text-center'>عذراً، هذا المنتج غير موجود.</div>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        .main-img { max-width: 100%; border-radius: 12px; transition: 0.3s; }
        .main-img:hover { transform: scale(1.02); }
        .recent-box { border-bottom: 1px solid #eee; padding: 10px 0; }
        .recent-box img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>

<main class="container my-5">
    <div class="row">
        <div class="col-md-6 mb-4 text-center">
            <img src="uploads/img/<?php echo $product['product_image']; ?>" class="main-img shadow" alt="صورة المنتج">
        </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">الرئيسية</a></li>
                    <li class="breadcrumb-item active"><?php echo $product['product_section']; ?></li>
                </ol>
            </nav>

            <h1 class="display-6 fw-bold"><?php echo $product['product_name']; ?></h1>
            
            <h3 class="text-danger my-3"><?php echo $product['product_price']; ?> SAR</h3>
            
            <div class="my-4 pt-3 border-top">
                <h5 class="fw-bold">تفاصيل المنتج:</h5>
                <p class="text-muted lead" style="line-height: 1.8;">
                    <?php echo $product['product_desc']; ?>
                </p>
            </div>

            <form action="cart.php" method="POST">
                <input type="hidden" name="h_name" value="<?php echo $product['product_name']; ?>">
                <input type="hidden" name="h_price" value="<?php echo $product['product_price']; ?>">
                <input type="hidden" name="h_image" value="<?php echo $product['product_image']; ?>">

                <div class="d-flex align-items-center mb-4">
                    <input type="number" name="quantity" value="1" min="1" class="form-control me-2 text-center" style="width: 80px;">
                    
                    <button type="submit" name="add_to_cart" class="btn btn-warning btn-lg w-100 text-white fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i> إضافة إلى السلة
                    </button>
                </div>
            </form>
            </div>
    </div>

    <hr class="my-5">

    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-4">منتجات حديثة</h4>
            <?php 
            $recent_stmt = $conn->prepare("SELECT * FROM product WHERE id != ? ORDER BY RAND() LIMIT 3");
            $recent_stmt->execute([$id]);
            
            while($recent = $recent_stmt->fetch()): 
            ?>
                <div class="d-flex align-items-center mb-3">
                    <a href="details.php?id=<?php echo $recent['id']; ?>">
                        <img src="uploads/img/<?php echo $recent['product_image']; ?>" style="width:60px; height:60px; object-fit:cover;" class="me-2">
                    </a>
                    <div>
                        <a href="details.php?id=<?php echo $recent['id']; ?>" class="text-dark text-decoration-none fw-bold">
                            <?php echo $recent['product_name']; ?>
                        </a>
                        <p class="text-danger small mb-0"><?php echo $recent['product_price']; ?> SAR</p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include('file/footer.php'); ?>
</body>
</html>