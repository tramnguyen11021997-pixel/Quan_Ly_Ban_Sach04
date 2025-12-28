<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'nhom4' && $password === '12345678') {
    $_SESSION['user'] = $username; // giữ session
    header("Location: admin/home.php"); // 🔴 sửa đường dẫn
    exit();
} else {
    header("Location: login.php?error=Sai tài khoản hoặc mật khẩu");
    exit();
}
