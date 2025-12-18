<?php
session_start();      // Bật session
session_destroy();    // Xoá toàn bộ thông tin đăng nhập
header("Location: index.php"); // Quay về trang đăng nhập
exit();
?>
