<?php
session_start();
include '../includes/db.php'; 

// Bảo mật: Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    
    // Tắt kiểm tra khóa ngoại tạm thời để tránh lỗi #1451
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    $sql = "DELETE FROM customers WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
        // Quay lại trang danh sách kèm thông báo thành công
        header("Location: customers.php?status=deleted"); 
    } else {
        echo "Lỗi khi xóa: " . mysqli_error($conn);
    }
} else {
    header("Location: customers.php");
}
exit();