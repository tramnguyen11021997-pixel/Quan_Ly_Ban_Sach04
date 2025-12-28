<?php
session_start();
include 'includes/db.php'; 

// Kiểm tra đăng nhập
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Sử dụng Prepared Statement để bảo mật
    $stmt = $conn->prepare("INSERT INTO books_temp (name, author, price, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $author, $price, $category);

    if($stmt->execute()){
        header("Location: books.php");
        exit();
    } else {
        $error = "❌ Lỗi hệ thống: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sách mới - BookStore</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- RESET & BASE STYLES --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f4ece1;
            background-image: radial-gradient(#d9c5b2 0.5px, transparent 0.5px); 
            background-size: 20px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* --- FORM CONTAINER --- */
        .form-box {
            width: 100%;
            max-width: 480px;
            background: #fffcf5;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(61, 43, 31, 0.12);
            border: 1px solid #e0d5c1;
            position: relative;
        }

        h2 {
            text-align: center;
            font-family: 'Cinzel Decorative', cursive;
            color: #3d2b1f;
            margin-bottom: 30px;
            font-size: 26px;
            border-bottom: 2px solid #c5a059;
            padding-bottom: 10px;
            display: inline-block;
            width: 100%;
        }

        /* --- FORM ELEMENTS --- */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #5d4037;
            font-size: 15px;
        }

        label i {
            margin-right: 5px;
            color: #c5a059;
            width: 20px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            border: 2px solid #eee1d7;
            font-family: 'Quicksand', sans-serif;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        input:focus {
            outline: none;
            border-color: #c5a059;
            box-shadow: 0 0 10px rgba(197, 160, 89, 0.15);
            background-color: #ffffff;
        }

        /* --- BUTTONS --- */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: #3d2b1f;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: #c5a059;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(197, 160, 89, 0.4);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* --- MESSAGES & LINKS --- */
        .error-msg {
            background: #fdf2f2;
            color: #9b2c2c;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border-left: 5px solid #e53e3e;
            font-weight: 600;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #7a5c48;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #c5a059;
            text-decoration: underline;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 480px) {
            .form-box {
                padding: 25px;
                border-radius: 15px;
            }
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>➕ THÊM SÁCH MỚI</h2>

    <?php if($error): ?>
        <div class="error-msg">
            <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-group">
            <label><i class="fa-solid fa-book"></i> Tên sách</label>
            <input type="text" name="name" placeholder="Ví dụ: Đắc Nhân Tâm" required>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-pen-nib"></i> Tác giả</label>
            <input type="text" name="author" placeholder="Ví dụ: Dale Carnegie" required>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-tag"></i> Giá (VNĐ)</label>
            <input type="number" name="price" placeholder="Nhập giá tiền..." step="0.01" required>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-layer-group"></i> Thể loại</label>
            <input type="text" name="category" placeholder="Ví dụ: Văn học, Kỹ năng..." required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fa-solid fa-floppy-disk"></i> Lưu vào hệ thống
        </button>
    </form>

    <a href="books.php" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách quản lý
    </a>
</div>

</body>
</html>
