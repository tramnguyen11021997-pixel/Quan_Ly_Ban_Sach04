<?php
$servername = "localhost";
$username = "root";      
$password = "";          
$dbname = "bookstore";   

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập tiếng Việt để không bị lỗi font khi hiển thị tên sách
$conn->set_charset("utf8mb4");
?>