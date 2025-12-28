<?php
session_start();

/* ================= KẾT NỐI DATABASE ================= */
include '../includes/db.php';

/* ================= KIỂM TRA ĐĂNG NHẬP ================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

/* ================= TÌM KIẾM ================= */
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$sql = "SELECT id, name, phone, address FROM customers";
if ($keyword !== '') {
    $safe = mysqli_real_escape_string($conn, $keyword);
    $sql .= " WHERE name LIKE '%$safe%' OR phone LIKE '%$safe%'";
}

/* 👉 KHÔNG ĐỔI ID – CHỈ SẮP XẾP */
$sql .= " ORDER BY id ASC";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi SQL: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách khách hàng</title>

<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{ box-sizing:border-box }

body{
    font-family:'Quicksand',sans-serif;
    background:#f4ece1;
    padding:25px;
    margin:0;
}

.container{
    max-width:1200px;
    margin:0 auto;
    background:#fffcf5;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    font-family:'Cinzel Decorative',cursive;
    margin-bottom:30px;
}

.btn{
    padding:12px 25px;
    border-radius:30px;
    text-decoration:none;
    font-weight:bold;
    border:none;
    cursor:pointer;
}

.btn-main{
    background:#3d2b1f;
    color:white;
}

.btn-sub{
    border:1px solid #3d2b1f;
    color:#3d2b1f;
    background:transparent;
}

.search-box{
    display:flex;
    justify-content:center;
    gap:10px;
    margin-bottom:25px;
}

.search-box input{
    width:320px;
    padding:12px 18px;
    border-radius:30px;
    border:1px solid #ccc;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th,td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:left;
}

th{
    background:#f7f2ea;
}

.id-badge{
    color:#c5a059;
    font-weight:bold;
}

.action a{
    font-size:20px;
    margin:0 6px;
    text-decoration:none;
}
</style>
</head>

<body>
<div class="container">

<h2>👥 DANH SÁCH KHÁCH HÀNG</h2>

<form method="get" class="search-box">
    <input type="text" name="keyword" placeholder="Tìm tên hoặc SĐT"
           value="<?= htmlspecialchars($keyword) ?>">
    <button type="submit" class="btn btn-main">Tìm Kiếm</button>
    <a href="customers.php" class="btn btn-sub">Hủy Lọc</a>
</form>

<div style="display:flex;justify-content:space-between;margin-bottom:20px">
    <a href="home.php" class="btn btn-sub">⬅ Trang chủ</a>
    <a href="customer_add.php" class="btn btn-main">➕ Thêm khách</a>
</div>

<table>
<thead>
<tr>
    <th>Mã</th>
    <th>Họ tên</th>
    <th>SĐT</th>
    <th>Địa chỉ</th>
    <th>Thao tác</th>
</tr>
</thead>
<tbody>

<?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td class="id-badge">#<?= (int)$row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['address']) ?></td>
        <td class="action">
            <a href="customer_edit.php?id=<?= (int)$row['id'] ?>">✏️</a>
            <a href="customer_delete.php?id=<?= (int)$row['id'] ?>"
               onclick="return confirm('Xóa khách này?')">🗑️</a>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5" style="text-align:center;color:#999;padding:30px">
            Không có dữ liệu khách hàng
        </td>
    </tr>
<?php endif; ?>

</tbody>
</table>

</div>
</body>
</html>
