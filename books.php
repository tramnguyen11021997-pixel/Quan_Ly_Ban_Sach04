<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, "utf8");

$category = $_GET['category'] ?? '';

if ($category) {
    $sql = "SELECT * FROM books WHERE category = '$category'";
} else {
    $sql = "SELECT * FROM books";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sách</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg,#f3e9dc,#e6d3b3);
    margin: 0;
    padding: 40px;
}
.container {
    background: #fff;
    max-width: 1000px;
    margin: auto;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}
.top {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    margin-bottom: 20px;
}
.top h2 {
    text-align: center;
    color: #5a3825;
}
.btn {
    background: #8b5e34;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
}
.btn:hover {
    background: #6e4524;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}
th, td {
    padding: 14px;
    text-align: center;
}
th {
    background: #8b5e34;
    color: white;
}
tr:nth-child(even) {
    background: #f7f1e6;
}
.actions a {
    margin: 0 4px;
}
</style>
</head>
<body>

<div class="container">
    <div class="top">
        <a class="btn" href="home.php">⬅ Trang chủ</a>
        <h2>📚 Quản lý sách</h2>
        <a class="btn" href="books_add.php">➕ Thêm sách</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Giá</th>
            <th>Thao tác</th>
        </tr>
            <?php if (mysqli_num_rows($result) == 0): ?>
                <tr>
                    <td colspan="5">Chưa có sách</td>
                </tr>
            <?php else: ?>
            <?php while ($b = mysqli_fetch_assoc($result)): ?>
                    <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= htmlspecialchars($b['name']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><?= number_format($b['price']) ?> đ</td>
                    <td class="actions">    
                        <a class="btn" href="books_edit.php?id=<?= $b['id'] ?>">✏ Sửa</a>
                        <a class="btn" href="books_delete.php?id=<?= $b['id'] ?>"
                            onclick="return confirm('Xóa sách này?')">🗑 Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>

    </table>
</div>

</body>
</html>
