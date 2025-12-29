<?php
require_once '../includes/db.php';

if (isset($_POST['add_staff'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Bạn nên dùng password_hash để bảo mật
    $position = $_POST['position'];

    $sql = "INSERT INTO staff (fullname, username, password, phone, position) 
            VALUES ('$fullname', '$username', '$password', '$phone', '$position')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: staff.php");
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>