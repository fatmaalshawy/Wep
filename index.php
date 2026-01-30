<?php 
include('include/connected.php');
include ('file/header.php');
// session_start(); // تفعيل الجلسة للبدء في استخدام السلة
?>

<main class="container my-5">
    <div class="d-flex align-items-center border-bottom pb-2 mb-4">
        <h2 class="text-secondary mb-0 me-3">مضاف حديثاً</h2>
        <div class="d-flex gap-2">
           <?php
            // استعلام لجلب آخر 4 صور للمنتجات المضافة حديثاً
            $stmt_recent = $conn->query("SELECT id, product_image FROM product ORDER BY id DESC LIMIT 4");
            while ($recent = $stmt_recent->fetch()) {
                echo '<a href="details.php?id=' . $recent['id'] . '">
                        <img src="uploads/img/' . $recent['product_image'] . '" class="rounded-circle small-post-img" style="width:40px; height:40px; object-fit:cover;" alt="منتج حديث">
                      </a>';
            }
            ?>
        </div>
    </div>

    <div class="row" id="product-list">
        <?php
        // جلب كافة المنتجات من قاعدة البيانات
        $stmt = $conn->query("SELECT * FROM product");
        while ($row = $stmt->fetch()) {  
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <form action="cart.php" method="POST">
                    <div class="card shadow-sm h-100 position-relative">
                        
                        <a href="details.php?id=<?php echo $row['id']; ?>" class="product-img-container d-block">
                            <img src="uploads/img/<?php echo $row['product_image']; ?>" 
                                 class="card-img-top img-fluid" 
                                 style="height: 200px; object-fit: contain;"
                                 alt="<?php echo $row['product_name']; ?>">
                        </a>

                        <div class="card-body text-center">
                            <small class="text-muted fw-bold product-section-tag"><?php echo $row['product_section']; ?></small>
                            
                            <h5 class="card-title mt-2 fw-bold">
                                <a href="details.php?id=<?php echo $row['id']; ?>" class="text-dark text-decoration-none">
                                    <?php echo $row['product_name']; ?>
                                </a>
                            </h5>

                            <p class="text-danger fs-5 fw-bolder"><?php echo $row['product_price']; ?> SAR</p>
                            
                            <input type="hidden" name="h_name" value="<?php echo $row['product_name']; ?>">
                            <input type="hidden" name="h_price" value="<?php echo $row['product_price']; ?>">
                            <input type="hidden" name="h_image" value="<?php echo $row['product_image']; ?>">

                          <a href="details.php?id=<?php echo $row['id']; ?>" 
   class="btn w-100 mt-2 text-white fw-bold" 
   style="background-color: #D4AF37; border: none;">
   <i class="fas fa-eye me-1"></i> عرض التفاصيل
</a>

                            <div class="d-flex justify-content-center align-items-center my-3">
                                <input type="number" name="quantity" class="form-control text-center quantity-input shadow-none" value="1" min="1" max="10" style="width: 80px;">
                            </div>

                            <button type="submit" name="add_to_cart" class="btn btn-primary w-100 mt-2">
                                <i class="fas fa-shopping-cart me-1"></i> أضف إلى السلة
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        } 
        ?>
    </div> 
</main>

<?php 
include ('file/footer.php');
?>