<?php
include('include/connected.php');
session_start();

if(isset($_POST['order_btn'])){

   $user_id = $_SESSION['user_id'];
   $name = $_POST['name'];
   $number = $_POST['number'];
   $method = $_POST['method'];
   $address = $_POST['address'];
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   // 1. جلب كل المنتجات من السلة لتحويلها لطلب واحد
   $cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
   $cart_query->execute([$user_id]);

   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch()){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
      
      $total_products = implode(', ', $cart_products);

      // 2. إدخال بيانات الطلب في جدول order الجديد
      $insert_order = $conn->prepare("INSERT INTO `order`(user_id, name, number, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $method, $address, $total_products, $cart_total, $placed_on]);

      // 3. تفريغ السلة لهذا المستخدم بعد نجاح الطلب
      $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      echo "<script>
         alert('تم تسجيل طلبك بنجاح! شكراً لتسوقك معنا');
         window.location.href='index.php';
      </script>";
   }else{
      echo "<script>alert('سلتك فارغة حالياً!'); window.location.href='index.php';</script>";
   }
}
?>