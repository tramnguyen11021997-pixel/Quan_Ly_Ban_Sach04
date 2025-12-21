<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'nhom4' && $password === '12345678') {
    $_SESSION['user'] = $username;
    header("Location: books.php");
    exit();
} else {
    header("Location: login.php?error=Sai tài khoản hoặc mật khẩu");
    exit();
}
