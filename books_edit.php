<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: books.php");
    exit();
}

$id = $_GET['id'];
$books = $_SESSION['books'];

$book = null;
$pos = null;

foreach ($books as $index => $b) {
    if ($b['id'] == $id) {
        $book = $b;
        $pos = $index;
        break;
    }
}

if ($book === null) {
    header("Location: books.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $books[$pos]['name']   = $_POST['name'];
    $books[$pos]['author'] = $_POST['author'];
    $books[$pos]['price']  = $_POST['price'];

    $_SESSION['books'] = $books;
    header("Location: books.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa sách</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(120deg, #f3e9dc, #e6d3b3);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.box {
    background: #fff;
    width: 420px;
    padding: 30px 32px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #5a3a1a;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 6px;
}

input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin-bottom: 16px;
    font-size: 14px;
}

input:focus {
    border-color: #8b5a2b;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 25px;
    background: #8b5a2b;
    color: white;
    font-size: 15px;
    cursor: pointer;
}

button:hover {
    background: #6e4524;
}

.back {
    display: block;
    margin-top: 16px;
    text-align: center;
    text-decoration: none;
    color: #8b5a2b;
    font-size: 14px;
}

.back:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div class="box">
    <h2>✏ Sửa thông tin sách</h2>

    <form method="post">
        <label>Tên sách</label>
        <input type="text" name="name" value="<?= htmlspecialchars($book['name']) ?>" required>

        <label>Tác giả</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

        <label>Giá</label>
        <input type="number" name="price" value="<?= $book['price'] ?>" required>

        <button type="submit">💾 Lưu thay đổi</button>
    </form>

    <a href="books.php" class="back">⬅ Quay lại quản lý sách</a>
</div>

</body>
</html>
