<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $book_id     = $_POST['book_id'];
    $quantity    = $_POST['quantity'];

    // 1. Lấy giá sách hiện tại
    $res_book = mysqli_query($conn, "SELECT price, stock FROM books WHERE id = $book_id");
    $book = mysqli_fetch_assoc($res_book);
    
    if ($book['stock'] < $quantity) {
        die("Lỗi: Số lượng trong kho không đủ!");
    }

    $total_price = $book['price'] * $quantity;

    // 2. Lưu vào bảng orders
    $sql_order = "INSERT INTO orders (customer_id, total_amount) VALUES ($customer_id, $total_price)";
    mysqli_query($conn, $sql_order);
    $order_id = mysqli_insert_id($conn); // Lấy ID đơn hàng vừa tạo

    // 3. Lưu vào bảng order_details
    $sql_detail = "INSERT INTO order_details (order_id, book_id, quantity, price) 
                   VALUES ($order_id, $book_id, $quantity, {$book['price']})";
    mysqli_query($conn, $sql_detail);

    // 4. TRỪ TỒN KHO SÁCH
    $sql_update_stock = "UPDATE books SET stock = stock - $quantity WHERE id = $book_id";
    mysqli_query($conn, $sql_update_stock);

    header("Location: orders.php?msg=success");
    exit();
}
?>