<?php
include('include/connected.php');
include('file/header.php');

// التأكد من وجود منتجات في السلة قبل الشراء
$user_id = $_SESSION['user_id'];
$check_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$check_cart->execute([$user_id]);

if($check_cart->rowCount() == 0){
    echo "<script>alert('سلتك فارغة، أضف منتجات أولاً'); window.location.href='index.php';</script>";
    exit();
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4"><i class="fas fa-cash-register text-primary"></i> إتمام عملية الشراء</h2>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm p-4">
                <h5 class="border-bottom pb-2 mb-3">بيانات الشحن</h5>
                <form action="order_process.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" required placeholder="أدخل اسمك الثلاثي">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="number" name="number" class="form-control" required placeholder="05xxxxxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العوان بالتفصيل</label>
                        <textarea name="address" class="form-control" required placeholder="المدينة، الحي، الشارع"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">طريقة الدفع</label>
                        <select name="method" class="form-select">
                            <option value="كاش">الدفع عند الاستلام</option>
                            <option value="بطاقة">بطاقة مدى / فيزا</option>
                        </select>
                    </div>
<button type="submit" name="order_btn" class="btn btn-success w-100 fw-bold text-white py-2">
   تثبيت الطلب الآن
</button>                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card bg-light p-3">
                <h5 class="text-secondary">ملخص طلبك</h5>
                <hr>
                <?php
                $grand_total = 0;
                $check_cart->execute([$user_id]);
                while($item = $check_cart->fetch()){
                    $sub_total = ($item['price'] * $item['quantity']);
                    $grand_total += $sub_total;
                    echo "<p class='d-flex justify-content-between'>
                            <span>{$item['name']} ({$item['quantity']})</span>
                            <span class='fw-bold'>{$sub_total} SAR</span>
                          </p>";
                }
                ?>
                <hr>
                <h4 class="d-flex justify-content-between text-danger">
                    <span>الإجمالي النهائي:</span>
                    <span><?php echo $grand_total; ?> SAR</span>
                </h4>
            </div>
        </div>
    </div>
</div>

<?php include('file/footer.php'); ?>