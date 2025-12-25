<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, "utf8");

$id = $_GET['id'];
$message = "";

// 1. Lấy thông tin cũ của khách hàng này
$sql_old = "SELECT * FROM customers WHERE id = $id";
$res_old = mysqli_query($conn, $sql_old);
$old_data = mysqli_fetch_assoc($res_old);

// 2. Xử lý khi nhấn nút "Cập nhật"
if (isset($_POST['btn_update'])) {
    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $email   = $_POST['email'];
    $address = $_POST['address'];

    $sql_update = "UPDATE customers SET name='$name', phone='$phone', email='$email', address='$address' WHERE id=$id";
    
    if (mysqli_query($conn, $sql_update)) {
        $message = "<p style='color: green;'>✅ Cập nhật thành công!</p>";
        header("refresh:1; url=customers.php");
    } else {
        $message = "<p style='color: red;'>❌ Lỗi: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin khách hàng</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f1ea; padding: 40px; }
        .container { background: white; max-width: 500px; margin: auto; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        h2 { color: #5a3825; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 12px; border-radius: 25px; border: none; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; }
        .btn-update { background: #8b5e34; color: white; }
        .btn-back { background: #eee; color: #333; }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Sửa khách hàng #<?= $id ?></h2>
    <?= $message ?>
    <form method="POST">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="name" value="<?= htmlspecialchars($old_data['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($old_data['phone']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($old_data['email']) ?>">
        </div>
        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="address" rows="3"><?= htmlspecialchars($old_data['address']) ?></textarea>
        </div>
        <div class="btn-group">
            <a href="customers.php" class="btn btn-back">Quay lại</a>
            <button type="submit" name="btn_update" class="btn btn-update">Cập nhật</button>
        </div>
    </form>
</div>

</body>
</html>