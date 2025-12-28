<?php
session_start();
include 'includes/db.php';

// Kiểm tra quyền truy cập
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// Lấy ID và ép kiểu về số nguyên để an toàn hơn
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id > 0){
    $stmt = $conn->prepare("DELETE FROM books_temp WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()){
        // Có thể thêm thông báo thành công vào session nếu muốn
        $_SESSION['msg'] = "Xóa sách thành công!";
    } else {
        $_SESSION['msg'] = "Lỗi: Không thể xóa dữ liệu!";
    }
    $stmt->close();
}

header("Location: books.php");
exit();