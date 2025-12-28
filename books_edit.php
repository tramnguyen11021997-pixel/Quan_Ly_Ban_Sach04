<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? '';
if(!$id){ header("Location: books.php"); exit(); }

$error = '';
$stmt = $conn->prepare("SELECT * FROM books_temp WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
if(!$book){ header("Location: books.php"); exit(); }

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = $_POST['name'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE books_temp SET name=?, author=?, price=?, category=? WHERE id=?");
    $stmt->bind_param("ssdsi",$name,$author,$price,$category,$id);

    if($stmt->execute()){
        header("Location: books.php");
        exit();
    }else{
        $error = "❌ Lỗi: ".$conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chỉnh sửa sách - BookStore</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family:'Quicksand',sans-serif;
    background:linear-gradient(135deg,#f4ece1,#e9ddcf);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.form-box{
    width:100%;
    max-width:480px;
    background:#ffffff;
    padding:35px 40px;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
    animation:fadeIn 0.4s ease-in-out;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

h2{
    text-align:center;
    font-family:'Cinzel Decorative',cursive;
    color:#3d2b1f;
    margin-bottom:25px;
    letter-spacing:1px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:700;
    color:#4a3423;
}

input{
    width:100%;
    padding:12px 14px;
    margin-bottom:18px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
    transition:0.25s;
}

input:focus{
    outline:none;
    border-color:#c5a059;
    box-shadow:0 0 0 2px rgba(197,160,89,0.25);
}

button{
    width:100%;
    padding:13px;
    background:#3d2b1f;
    color:#fff;
    border:none;
    border-radius:30px;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

button i{
    margin-right:6px;
}

button:hover{
    background:#c5a059;
    transform:translateY(-1px);
}

.error-msg{
    background:#fdecec;
    color:#a94442;
    padding:12px;
    border-radius:10px;
    margin-bottom:18px;
    text-align:center;
    font-weight:600;
    border:1px solid #f5c2c2;
}
.back-link{
    display:block;
    margin-top:18px;
    text-align:center;
    color:#3d2b1f;
    font-weight:700;
    text-decoration:none;
    transition:0.3s;
}

.back-link i{
    margin-right:5px;
}

.back-link:hover{
    color:#c5a059;
}
</style>

</head>
<body>
<div class="form-box">
<h2>✏️ CHỈNH SỬA SÁCH</h2>

<?php if($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>

<form method="post">
<label>Tên sách</label>
<input type="text" name="name" value="<?= htmlspecialchars($book['name']) ?>" required>

<label>Tác giả</label>
<input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

<label>Giá (VNĐ)</label>
<input type="number" name="price" value="<?= htmlspecialchars($book['price']) ?>" required>

<label>Thể loại</label>
<input type="text" name="category" value="<?= htmlspecialchars($book['category']) ?>" required>

<button type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi</button>
</form>

<a href="books.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Quay lại quản lý</a>
</div>
</body>
</html>