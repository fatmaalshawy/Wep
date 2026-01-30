<?php 
// 1. الاتصال وتضمين الهيدر
include('include/connected.php'); 
include('file/header.php'); 

// 2. التحقق من وجود القسم في الرابط
if(isset($_GET['section'])){
    $section_name = $_GET['section']; // تعريف المتغير هنا
    
    // 3. استعلام جلب المنتجات حسب القسم
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_section = ? ORDER BY id DESC");
    $stmt->execute([$section_name]);
    $products = $stmt->fetchAll();
} else {
    // إذا لم يتم اختيار قسم، التوجه للرئيسية
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
?>

<main class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold border-bottom pb-2">قسم: <span class="text-primary"><?php echo $section_name; ?></span></h2>
        </div>
    </div>

    <div class="row">
        <?php 
        // 4. فحص النتائج
        if($products): 
            foreach($products as $row): 
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm h-100">
                    <a href="details.php?id=<?php echo $row['id']; ?>">
                        <img src="uploads/img/<?php echo $row['product_image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold"><?php echo $row['product_name']; ?></h5>
                        <p class="text-danger fw-bold"><?php echo $row['product_price']; ?> SAR</p>
                        <a href="details.php?id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm w-100">التفاصيل</a>
                    </div>
                </div>
            </div>
        <?php 
            endforeach; 
        else: 
            // 5. إذا كان القسم فارغاً
        ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-light border p-5 shadow-sm">
                    <i class="fas fa-search mb-3 fa-3x text-muted"></i>
                    <h4 class="text-muted">عذراً، لا توجد منتجات متوفرة في قسم (<?php echo $section_name; ?>) حالياً.</h4>
                    <a href="index.php" class="btn btn-primary mt-3">تصفح باقي الأقسام</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('file/footer.php'); ?>