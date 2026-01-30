<?php 
include('include/connected.php');
include ('file/header.php');

// استقبال كلمة البحث وتجهيزها
$search_results = [];
if (isset($_GET['search_btn']) && !empty($_GET['search_query'])) {
    $search = "%" . $_GET['search_query'] . "%";

    // استعلام البحث بأسلوب PDO (آمن جداً)
    $sql = "SELECT * FROM product WHERE 
            product_name LIKE :query OR 
            product_price LIKE :query OR 
            product_section LIKE :query OR 
            id LIKE :query";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute(['query' => $search]);
    $search_results = $stmt->fetchAll();
}
?>

<main class="container my-5">
    <div class="border-bottom pb-2 mb-4">
        <h2 class="text-secondary">نتائج البحث عن: <span class="text-primary"><?php echo @$_GET['search_query']; ?></span></h2>
    </div>

    <div class="row">
        <?php if (count($search_results) > 0): ?>
            <?php foreach ($search_results as $row): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="uploads/img/<?php echo $row['product_image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body text-center">
                            <small class="text-muted"><?php echo $row['product_section']; ?></small>
                            <h5 class="card-title fw-bold"><?php echo $row['product_name']; ?></h5>
                            <p class="text-danger fw-bold"><?php echo $row['product_price']; ?> SAR</p>
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white">تعديل</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-light border shadow-sm p-5">
                    <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                    <h4 class="text-secondary">عذراً، المنتج الذي تبحث عنه غير متوفر حالياً</h4>
                    <p class="text-muted">جرب البحث بكلمة أخرى أو برقم المنتج.</p>
                    <a href="index.php" class="btn btn-primary mt-3">العودة للمتجر</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include ('file/footer.php'); ?>