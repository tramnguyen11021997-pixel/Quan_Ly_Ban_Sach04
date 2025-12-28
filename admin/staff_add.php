<?php
require_once '../includes/db.php';
$error = ""; // Biến lưu lỗi

if (isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $position = $_POST['position'];

    // 1. Kiểm tra xem username đã tồn tại chưa
    $check_sql = "SELECT id FROM staff WHERE username = '$username'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        $error = "Lỗi: Tên đăng nhập '$username' đã tồn tại. Vui lòng chọn tên khác!";
    } else {
        // 2. Nếu chưa tồn tại thì mới thêm
        $sql = "INSERT INTO staff (fullname, username, password, phone, position) VALUES ('$fullname', '$username', '$password', '$phone', '$position')";
        if (mysqli_query($conn, $sql)) {
            header("Location: staff.php");
            exit();
        } else {
            $error = "Có lỗi xảy ra khi lưu dữ liệu!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm nhân viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #f4ece1; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fffcf5; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; border: 1px solid #e0d5c5; }
        h3 { color: #3d2b1f; text-align: center; margin-bottom: 25px; }
        
        /* Thông báo lỗi rõ ràng */
        .error-msg { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border: 1px solid #f5c6cb; text-align: center; font-weight: 600; }
        
        label { display: block; margin-bottom: 5px; font-weight: 700; color: #555; font-size: 13px; }
        input, select { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; font-family: inherit; }
        .btn-save { width: 100%; padding: 14px; background: #3d2b1f; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <h3>THÊM NHÂN VIÊN</h3>

    <?php if ($error != ""): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Họ và tên</label>
        <input type="text" name="fullname" placeholder="Nhập họ tên" required value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?>">
        
        <label>Tên đăng nhập (Username)</label>
        <input type="text" name="username" placeholder="Ví dụ: nhanvien01" required>
        
        <label>Mật khẩu</label>
        <input type="password" name="password" required>
        
        <label>Số điện thoại</label>
        <input type="text" name="phone" placeholder="Nhập SĐT" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
        
        <label>Chức vụ</label>
        <select name="position">
            <option value="Bán hàng">Bán hàng</option>
            <option value="Thủ kho">Thủ kho</option>
            <option value="Quản lý">Quản lý</option>
        </select>
        
        <button type="submit" name="submit" class="btn-save">LƯU NHÂN VIÊN</button>
        <a href="staff.php" class="btn-back">Quay lại danh sách</a>
    </form>
</div>
</body>
</html>