<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "bookstore");

// Lấy ID từ thanh địa chỉ
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Câu lệnh xóa
    $sql = "DELETE FROM customers WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: customers.php"); // Xóa xong quay về danh sách
        exit();
    } else {
        echo "Lỗi khi xóa: " . mysqli_error($conn);
    }
}
?>