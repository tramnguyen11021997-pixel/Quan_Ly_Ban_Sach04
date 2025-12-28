<?php
require_once '../includes/db.php';

/* ================== DANH SÁCH ĐƠN HÀNG + SÁCH ĐÃ MUA ================== */
$sqlOrders = "
SELECT 
    o.id,
    o.customer_name,
    o.phone,
    o.total_price,
    o.order_date,
    GROUP_CONCAT(
        DISTINCT CONCAT(b.name, ' (x', oi.quantity, ')')
        ORDER BY b.name
        SEPARATOR ', '
    ) AS books
FROM orders o
LEFT JOIN order_items oi ON o.id = oi.order_id
LEFT JOIN books b ON oi.book_id = b.id
GROUP BY o.id
ORDER BY o.id DESC
";
$orders = mysqli_query($conn, $sqlOrders);

/* ================== SÁCH BÁN CHẠY THEO THÁNG ================== */
$sqlBestSeller = "
SELECT 
    b.name AS book_name,
    SUM(oi.quantity) AS total_sold
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
JOIN books b ON oi.book_id = b.id
WHERE MONTH(o.order_date) = MONTH(CURRENT_DATE())
  AND YEAR(o.order_date) = YEAR(CURRENT_DATE())
GROUP BY b.id, b.name
HAVING total_sold > 0
ORDER BY total_sold DESC
LIMIT 10
";
$bestSeller = mysqli_query($conn, $sqlBestSeller);

/* ================== SÁCH TỒN KHO (ÍT NHẤT) ================== */
$sqlStock = "
SELECT 
    name,
    stock
FROM books
WHERE stock > 0
ORDER BY stock ASC
LIMIT 5
";
$stock = mysqli_query($conn, $sqlStock);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý đơn hàng</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Quicksand', sans-serif;
    background-color: #f4ece1;
    padding: 20px;
}
.container {
    max-width: 1300px;
    margin: auto;
    background: #fffcf5;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    font-family: serif;
    color: #3d2b1f;
    margin-bottom: 25px;
}
.action-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}
.btn {
    padding: 10px 22px;
    background: #fff;
    color: #3d2b1f;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 13px;
    border: 1px solid #ddd;
    cursor: pointer;
}
.btn:hover {
    background: #3d2b1f;
    color: #fff;
}
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
}
th, td {
    padding: 14px;
    border-bottom: 1px solid #eee;
    text-align: center;
    vertical-align: top;
}
th {
    background: #f0e6d8;
    color: #3d2b1f;
    font-size: 13px;
}
.price {
    color: #b8860b;
    font-weight: bold;
}
.box {
    display: none;
    background: #fbf6ef;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
}
.rank {
    font-weight: bold;
    color: #b8860b;
}
.low {
    color: #c0392b;
    font-weight: bold;
}
.books {
    text-align: left;
    font-size: 14px;
    line-height: 1.6;
}
.empty {
    color: #999;
    font-style: italic;
}
</style>

<script>
function toggleBox(id) {
    const box = document.getElementById(id);
    box.style.display = box.style.display === 'none' ? 'block' : 'none';
}
</script>
</head>

<body>

<div class="container">
    <h2>📦 QUẢN LÝ ĐƠN HÀNG</h2>

    <div class="action-bar">
        <a href="home.php" class="btn">⬅ Trang chủ</a>
        <button class="btn" onclick="toggleBox('bestSeller')">📈 Sách bán chạy <?= date('m/Y') ?></button>
        <button class="btn" onclick="toggleBox('stock')">📦 Sách tồn kho</button>
    </div>

    <!-- SÁCH BÁN CHẠY -->
    <div id="bestSeller" class="box">
        <h3 style="text-align:center;">🔥 SÁCH BÁN CHẠY</h3>
        <table>
            <tr>
                <th>Hạng</th>
                <th>Tên sách</th>
                <th>Đã bán</th>
            </tr>
            <?php $rank = 1; while ($row = mysqli_fetch_assoc($bestSeller)): ?>
            <tr>
                <td class="rank">#<?= $rank++ ?></td>
                <td style="text-align:left;"><?= htmlspecialchars($row['book_name']) ?></td>
                <td><?= $row['total_sold'] ?> cuốn</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- SÁCH TỒN KHO -->
    <div id="stock" class="box">
        <h3 style="text-align:center;">📦 SÁCH TỒN KHO (ÍT NHẤT)</h3>
        <table>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Số lượng</th>
            </tr>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($stock)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td style="text-align:left;"><?= htmlspecialchars($row['name']) ?></td>
                <td class="<?= $row['stock'] <= 5 ? 'low' : '' ?>">
                    <?= $row['stock'] ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- DANH SÁCH ĐƠN HÀNG -->
    <table>
        <tr>
            <th>STT</th>
            <th>Khách hàng</th>
            <th>SĐT</th>
            <th>Đã mua sách</th>
            <th>Ngày mua</th>
            <th>Tổng tiền</th>
        </tr>
        <?php $stt = 1; while ($row = mysqli_fetch_assoc($orders)): ?>
        <tr>
            <td><?= $stt++ ?></td>
            <td style="text-align:left;"><?= htmlspecialchars($row['customer_name'] ?? 'Khách lẻ') ?></td>
            <td><?= htmlspecialchars($row['phone'] ?? '---') ?></td>
            <td class="books">
                <?php if (!empty($row['books'])): ?>
                    <?= htmlspecialchars($row['books']) ?>
                <?php else: ?>
                    <span class="empty">Đơn bán trực tiếp</span>
                <?php endif; ?>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($row['order_date'])) ?></td>
            <td class="price"><?= number_format($row['total_price']) ?> đ</td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
