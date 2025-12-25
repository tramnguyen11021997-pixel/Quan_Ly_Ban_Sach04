<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, "utf8");

$category = $_GET['category'] ?? '';

$category = $_GET['category'] ?? '';
$keyword  = $_GET['keyword'] ?? '';

$sql = "SELECT * FROM books WHERE 1";

if ($category) {
    $sql .= " AND category = '$category'";
}

if ($keyword) {
    $sql .= " AND (name LIKE '%$keyword%' OR author LIKE '%$keyword%')";
}

$result = mysqli_query($conn, $sql);


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
    display: flex;
    flex-direction: column; /* Xếp các thành phần theo hàng dọc */
    align-items: center;    /* Căn giữa tất cả theo chiều ngang */
    gap: 20px;              /* Khoảng cách giữa tiêu đề và thanh tìm kiếm */
    margin-bottom: 30px;
}

.top h2 {
    font-size: 35px;        /* Chữ to lên */
    color: #5a3825;
    margin: 0;              /* Bỏ khoảng cách thừa */
    font-weight: bold;
}
.bottom-actions {
    display: flex;
    justify-content: center; /* Căn giữa cả hàng */
    gap: 20px;               /* Khoảng cách giữa 2 nút */
    width: 100%;
}
.search-form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;              /* Khoảng cách giữa ô input, nút tìm kiếm và trang chủ */
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
.btn-home {
    background-color: #8b5a2b;
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    text-decoration: none;
    
    display: inline-block; 
    width: fit-content;    
    white-space: nowrap; 
    margin-left: 20px;
  }

  .btn-search:hover, .btn-home:hover {
    opacity: 0.9;
  }
  
</style>
</head>
<body>

<div class="container">
    <div class="top">
        <h2>📚 Quản lý sách</h2>

        <form method="GET" style="display: flex; gap: 10px; align-items: center;">
            <input 
                type="text" 
                name="keyword" 
                placeholder="🔍 Nhập tên sách hoặc tác giả..."
                value="<?= htmlspecialchars($keyword) ?>"
                style="padding:10px; width:300px; border-radius:20px; border:1px solid #ccc;"
        >
            <button class="btn" type="submit">Tìm kiếm</button>
            <?php if (!empty($keyword)): ?>
                <a class="btn" href="books.php">Xem tất cả</a>
            <?php endif; ?>
        </form>

        <div class="bottom-actions">
            <a class="btn-home" href="home.php">⬅ Trang chủ</a>
            <a class="btn" href="books_add.php" style="padding: 10px 20px;">➕ Thêm sách mới</a>
    </div>
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
