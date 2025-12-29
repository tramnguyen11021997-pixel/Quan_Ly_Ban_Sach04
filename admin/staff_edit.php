<?php
require_once '../includes/db.php';
$id = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM staff WHERE id = $id");
$data = mysqli_fetch_assoc($res);

if (isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $position = $_POST['position'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    mysqli_query($conn, "UPDATE staff SET fullname='$fullname', phone='$phone', position='$position', username='$username' WHERE id=$id");
    header("Location: staff.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật nhân viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #f4ece1; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fffcf5; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; border: 1px solid #c5a059; }
        h3 { color: #b8860b; text-align: center; margin-bottom: 25px; }
        label { display: block; margin-bottom: 5px; font-weight: 700; color: #555; font-size: 13px; }
        input, select { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; }
        .btn-update { width: 100%; padding: 14px; background: #b8860b; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <h3><i class="fa-solid fa-user-pen"></i> SỬA THÔNG TIN</h3>
    <form method="POST">
        <label>Họ và tên</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($data['fullname']) ?>" required>
        <label>Số điện thoại</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>">
        <label>Chức vụ</label>
        <select name="position">
            <option value="Bán hàng" <?= $data['position'] == 'Bán hàng' ? 'selected' : '' ?>>Bán hàng</option>
            <option value="Thủ kho" <?= $data['position'] == 'Thủ kho' ? 'selected' : '' ?>>Thủ kho</option>
            <option value="Quản lý" <?= $data['position'] == 'Quản lý' ? 'selected' : '' ?>>Quản lý</option>
        </select>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>
        <button type="submit" name="submit" class="btn-update">CẬP NHẬT NGAY</button>
        <a href="staff.php" class="btn-back">Quay lại danh sách</a>
    </form>
</div>
</body>
</html>