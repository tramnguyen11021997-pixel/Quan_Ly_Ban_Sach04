<?php
session_start();
include 'includes/db.php'; 

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = $_POST['name'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO books_temp (name, author, price, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $author, $price, $category);

    if($stmt->execute()){
        header("Location: books.php");
        exit();
    }else{
        $error = "❌ Lỗi: " . $conn->error;
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
body{font-family:'Quicksand',sans-serif;background:#f4ece1;padding:30px;}
.form-box{max-width:450px;margin:auto;background:#fffcf5;padding:40px;border-radius:20px;box-shadow:0 10px 30px rgba(0,0,0,0.1);}
h2{text-align:center;font-family:'Cinzel Decorative',cursive;color:#3d2b1f;margin-bottom:25px;}
label{display:block;margin:10px 0 5px;font-weight:700;}
input, select{width:100%;padding:12px;margin-bottom:15px;border-radius:10px;border:1px solid #ccc;font-size:14px;}
button{width:100%;padding:12px;background:#3d2b1f;color:white;border:none;border-radius:30px;cursor:pointer;font-weight:700;transition:0.3s;}
button:hover{background:#c5a059;}
.error-msg{background:#fbeaea;color:#a94442;padding:10px;border-radius:10px;margin-bottom:15px;text-align:center;}
.back-link{display:inline-block;margin-top:15px;color:#3d2b1f;text-decoration:none;font-weight:700;}
.back-link:hover{color:#c5a059;}
</style>
</head>
<body>
<div class="form-box">
<h2>➕ THÊM SÁCH MỚI</h2>

<?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>

<form method="post">
<label>Tên sách</label>
<input type="text" name="name" placeholder="Ví dụ: Đắc Nhân Tâm" required>

<label>Tác giả</label>
<input type="text" name="author" placeholder="Ví dụ: Dale Carnegie" required>

<label>Giá (VNĐ)</label>
<input type="number" name="price" placeholder="Nhập giá..." required>

<label>Thể loại</label>
<input type="text" name="category" placeholder="Ví dụ: Văn học" required>

<button type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
</form>

<a href="books.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Quay lại quản lý</a>
</div>
</body>
</html>
