<?php 
include('../include/connected.php'); 

try {
    //  جلب البيانات من جدول product
    $query = "SELECT * FROM product"; 
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("خطأ في جلب البيانات: " . $e->getMessage());
}
?>                                                                                                                          

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .product-img {
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .table align-middle td, .table align-middle th {
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">قائمة المنتجات (لوحة التحكم)</h5>
            <a href="add_product.php" class="btn btn-success btn-sm">إضافة منتج +</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>القسم</th>
                        <th class="text-center">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $row): ?>
                    <tr>
                        <td class="text-center">#<?php echo $row['id']; ?></td>
                        <td><img src="../uploads/img/<?php echo $row['product_image']; ?>" class="product-img shadow-sm" alt="product">
                    </td>
                        <td class="fw-bold"><?php echo $row['product_name']; ?></td>
                        <td class="text-success fw-bold"><?php echo $row['product_price']; ?> ريال</td>
                        <td><span class="badge bg-primary"><?php echo $row['product_section']; ?></span></td>
                        <td class="text-center">
                            <div class="btn-group gap-2">
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning btn-sm">تعديل</a>
                                <a href="delete_cat.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">حذف</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>