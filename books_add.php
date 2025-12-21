<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['books'])) {
        $_SESSION['books'] = [];
    }

    $id = count($_SESSION['books']) + 1;
    $_SESSION['books'][] = [
        'id' => $id,
        'name' => $_POST['name'],
        'author' => $_POST['author'],
        'price' => $_POST['price']
    ];

    header("Location: books.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sách</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg,#f3e9dc,#e6d3b3);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.form-box {
    background: white;
    padding: 35px;
    border-radius: 20px;
    width: 420px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
}
h2 {
    text-align: center;
    color: #5a3825;
}
input {
    width: 100%;
    padding: 12px;
    margin-top: 8px;
    margin-bottom: 18px;
    border-radius: 12px;
    border: 1px solid #ccc;
}
button {
    width: 100%;
    padding: 12px;
    background: #8b5e34;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
}
button:hover {
    background: #6e4524;
}
.back {
    text-align: center;
    margin-top: 15px;
}
.back a {
    color: #8b5e34;
    text-decoration: none;
}
</style>
</head>
<body>

<div class="form-box">
    <h2>➕ Thêm sách mới</h2>

    <form method="post">
        <label>Tên sách</label>
        <input type="text" name="name" required>

        <label>Tác giả</label>
        <input type="text" name="author" required>

        <label>Giá</label>
        <input type="number" name="price" required>

        <button type="submit">💾 Lưu sách</button>
    </form>

    <div class="back">
        <a href="books.php">⬅ Quay lại quản lý sách</a>
    </div>
</div>

</body>
</html>
