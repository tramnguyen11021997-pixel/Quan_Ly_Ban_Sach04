<?php
session_start();
include '../includes/db.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. LẤY DỮ LIỆU CŨ CỦA KHÁCH HÀNG
$res = mysqli_query($conn, "SELECT * FROM customers WHERE id = $id");
$row = mysqli_fetch_assoc($res);

if (!$row) {
    die("Khách hàng không tồn tại!");
}

// 2. XỬ LÝ CẬP NHẬT KHI NHẤN NÚT LƯU
if (isset($_POST['btn_update'])) {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE customers SET name='$name', phone='$phone', email='$email', address='$address' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>✅ Cập nhật thành công!</div>";
        header("refresh:1.2; url=customers.php");
    } else {
        $message = "<div class='alert error'>❌ Lỗi: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa khách hàng</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --cream: #f4ece1; --wood: #3d2b1f; --gold: #c5a059; --paper: #fffcf5; }
        body { font-family: 'Quicksand', sans-serif; background: var(--cream); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .box { background: var(--paper); padding: 40px; border-radius: 20px; width: 100%; max-width: 450px; box-shadow: 0 15px 40px rgba(0,0,0,0.1); text-align: center; border: 1px solid rgba(61,43,31,0.05); }
        h2 { font-family: 'Cinzel Decorative', cursive; color: var(--wood); margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 700; color: var(--wood); font-size: 14px; }
        input, textarea { width: 100%; padding: 12px; border: 1.5px solid #ddd; border-radius: 10px; font-size: 16px; box-sizing: border-box; outline: none; }
        .btn-update { width: 100%; padding: 15px; background: var(--wood); color: white; border: none; border-radius: 50px; font-weight: 700; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .btn-update:hover { background: var(--gold); }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
<div class="box">
    <h2><i class="fa-solid fa-user-pen"></i> SỬA THÔNG TIN</h2>
    <?= $message ?>
    <form method="POST">
        <div class="form-group">
            <label>Họ và Tên</label>
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>">
        </div>
        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="address" rows="2"><?= htmlspecialchars($row['address']) ?></textarea>
        </div>
        <button type="submit" name="btn_update" class="btn-update">CẬP NHẬT NGAY</button>
        <a href="customers.php" style="display:block; margin-top:20px; color:var(--wood); text-decoration:none; font-weight:700;">← QUAY LẠI</a>
    </form>
</div>
</body>
</html>