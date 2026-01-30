<?php 
include('include/connected.php');
include('file/header.php');
// session_start();

// 1. كود تحديث الكمية (Update)
if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_query = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    if ($update_query->execute([$update_value, $update_id])) {
        echo "<script>alert('تم تحديث الكمية بنجاح'); window.location.href='view_cart.php';</script>";
    }
}

// 2. كود حذف منتج (Remove)
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $delete_stmt->execute([$remove_id]);
    header('location:view_cart.php');
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4 fw-bold"><i class="fas fa-shopping-basket text-primary"></i> سلة المشتريات</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle bg-white text-center">
            <thead class="table-dark">
                <tr>
                    <th>الصورة</th>
                    <th>اسم المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>الإجمالي</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM cart");
                $grand_total = 0;

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch()) {
                        $sub_total = $row['price'] * $row['quantity'];
                        $grand_total += $sub_total;
                ?>
                <tr>
                    <td><img src="uploads/img/<?php echo $row['image']; ?>" width="60" class="img-thumbnail"></td>
                    <td class="fw-bold"><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?> SAR</td>
                    <td>
                        <form action="" method="post" class="d-flex justify-content-center align-items-center gap-1">
                            <input type="hidden" name="update_quantity_id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="update_quantity" min="1" value="<?php echo $row['quantity']; ?>" class="form-control form-control-sm text-center" style="width: 70px;">
                            <button type="submit" name="update_update_btn" class="btn btn-info btn-sm text-white">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </form>
                    </td>
                    <td class="text-danger fw-bold"><?php echo $sub_total; ?> SAR</td>
                    <td>
                        <a href="view_cart.php?remove=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف المنتج؟')">
                           <i class="fas fa-trash"></i> حذف
                        </a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo '<tr><td colspan="6" class="py-5 text-muted">السلة فارغة حالياً!</td></tr>';
                }
                ?>
            </tbody>
            <?php if ($grand_total > 0): ?>
            <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end fw-bold fs-5">إجمالي الفاتورة:</td>
                    <td colspan="2" class="text-danger fw-bold fs-5"><?php echo $grand_total; ?> SAR</td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-right"></i> متابعة التسوق</a>
        <?php if ($grand_total > 0): ?>
            <a href="checkout.php" class="btn btn-success fw-bold px-4 text-decoration-none">إتمام عملية الشراء <i class="fas fa-check-circle"></i></a>
        <?php endif; ?>
    </div>
</div>

<?php include ('file/footer.php'); ?>