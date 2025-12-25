<?php
session_start();
// 1. Bảo mật: Chỉ người dùng đã đăng nhập mới được vào
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// 2. Kết nối Database
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, "utf8");

$message = "";

// 3. Xử lý khi bấm nút "Lưu"
if (isset($_POST['btn_save'])) {
    // Lấy dữ liệu từ Form
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Kiểm tra các trường bắt buộc
    if (!empty($name) && !empty($phone)) {
        $sql = "INSERT INTO customers (name, phone, email, address) VALUES ('$name', '$phone', '$email', '$address')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert success'>✅ Thêm khách hàng thành công! Đang chuyển hướng...</div>";
            header("refresh:1.5; url=customers.php"); // Tự động quay về trang danh sách sau 1.5 giây
        } else {
            $message = "<div class='alert error'>❌ Lỗi: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert warning'>⚠️ Vui lòng nhập đầy đủ Họ tên và Số điện thoại!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khách hàng mới</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #f3e9dc, #e6d3b3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 500px;
            background: rgba(255,255,255,0.95);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: #4b2e23;
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #5a3825;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: #8b5e34;
            box-shadow: 0 0 8px rgba(139, 94, 52, 0.2);
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .warning { background: #fff3cd; color: #856404; }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 13px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .btn-save {
            background: #8b5e34;
            color: white;
            box-shadow: 0 4px 15px rgba(139, 94, 52, 0.3);
        }

        .btn-save:hover {
            background: #6e4524;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #fff;
            color: #8b5e34;
            border: 1px solid #8b5e34;
        }

        .btn-back:hover {
            background: #fdfaf6;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>➕ Thêm khách hàng</h2>

    <?= $message ?>

    <form method="POST">
        <div class="form-group">
            <label>Họ và tên *</label>
            <input type="text" name="name" placeholder="Nhập tên khách hàng" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại *</label>
            <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Địa chỉ email (không bắt buộc)">
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <textarea name="address" rows="3" placeholder="Nhập địa chỉ"></textarea>
        </div>

        <div class="btn-group">
            <a href="customers.php" class="btn btn-back">Hủy bỏ</a>
            <button type="submit" name="btn_save" class="btn btn-save">Lưu khách hàng</button>
        </div>
    </form>
</div>

</body>
</html>