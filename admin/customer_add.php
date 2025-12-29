<?php
session_start();
// 1. KẾT NỐI DATABASE
// Hãy đảm bảo file db.php nằm trong thư mục includes (ngang hàng với admin)
$db_path = '../includes/db.php';
if (file_exists($db_path)) {
    include $db_path;
} else {
    die("Lỗi: Không tìm thấy file kết nối database tại $db_path");
}

// 2. BẢO MẬT: Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";

// 3. XỬ LÝ KHI NHẤN NÚT LƯU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_save'])) {
    // Lấy dữ liệu và làm sạch để tránh lỗi SQL
    $name    = $conn->real_escape_string($_POST['name']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $email   = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);

    if (!empty($name) && !empty($phone)) {
        // Câu lệnh SQL chèn dữ liệu
        $sql = "INSERT INTO customers (name, phone, email, address) 
                VALUES ('$name', '$phone', '$email', '$address')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert success'>✅ Thêm khách hàng thành công! Đang quay lại...</div>";
            // Tự động chuyển trang sau 1.5 giây
            header("refresh:1.5; url=customers.php");
        } else {
            $message = "<div class='alert error'>❌ Lỗi Database: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='alert warning'>⚠️ Vui lòng nhập Họ tên và Số điện thoại!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khách Hàng - Artistic Archive</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --cream: #f4ece1; --wood: #3d2b1f; --gold: #c5a059; --paper: #fffcf5;
        }
        body {
            font-family: 'Quicksand', sans-serif; background: var(--cream);
            display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;
        }
        .form-box {
            background: var(--paper); padding: 40px; border-radius: 20px;
            width: 100%; max-width: 480px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            text-align: center; border: 1px solid rgba(61, 43, 31, 0.05);
        }
        h2 { font-family: 'Cinzel Decorative', cursive; color: var(--wood); margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 700; color: var(--wood); font-size: 14px; }
        input, textarea {
            width: 100%; padding: 12px; border: 1.5px solid #ddd; border-radius: 10px;
            font-size: 16px; box-sizing: border-box; outline: none;
        }
        input:focus { border-color: var(--gold); }
        .btn-group { display: flex; gap: 10px; margin-top: 25px; }
        .btn {
            flex: 1; padding: 14px; border-radius: 50px; border: none; font-weight: 700;
            cursor: pointer; text-transform: uppercase; text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-save { background: var(--wood); color: white; }
        .btn-save:hover { background: var(--gold); }
        .btn-back { background: transparent; color: var(--wood); border: 1.5px solid var(--wood); }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="form-box">
    <h2><i class="fa-solid fa-user-plus"></i> THÊM KHÁCH</h2>
    
    <?= $message ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Họ và Tên *</label>
            <input type="text" name="name" placeholder="Nguyễn Văn A" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại *</label>
            <input type="text" name="phone" placeholder="090..." required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="khach@gmail.com">
        </div>
        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="address" rows="2" placeholder="Địa chỉ..."></textarea>
        </div>
        
        <div class="btn-group">
            <a href="customers.php" class="btn btn-back">QUAY LẠI</a>
            <button type="submit" name="btn_save" class="btn btn-save">
                <i class="fa-solid fa-floppy-disk"></i> LƯU LẠI
            </button>
        </div>
    </form>
</div>

</body>
</html>