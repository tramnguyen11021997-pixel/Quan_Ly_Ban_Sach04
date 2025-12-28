<?php
session_start();
require_once '../includes/db.php';

/* 1. TRUY VẤN DANH SÁCH ĐƠN HÀNG */
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
LEFT JOIN books_temp b ON oi.book_id = b.id
GROUP BY o.id
ORDER BY o.id DESC
";
$orders = mysqli_query($conn, $sqlOrders);

/* 2. TRUY VẤN SÁCH BÁN CHẠY TRONG THÁNG HIỆN TẠI */
$sqlBestSeller = "
SELECT 
    b.name AS book_name,
    SUM(oi.quantity) AS total_sold
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
JOIN books_temp b ON oi.book_id = b.id
WHERE MONTH(o.order_date) = MONTH(CURRENT_DATE())
  AND YEAR(o.order_date) = YEAR(CURRENT_DATE())
GROUP BY b.id, b.name
HAVING total_sold > 0
ORDER BY total_sold DESC
LIMIT 10
";
$bestSeller = mysqli_query($conn, $sqlBestSeller);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --wood: #3d2b1f;
            --cream: #f4ece1;
            --gold: #b8860b;
        }
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--cream);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: #fffcf5;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: var(--wood);
            font-size: 28px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .action-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            justify-content: center;
        }
        .btn {
            padding: 12px 25px;
            background: white;
            color: var(--wood);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            background: var(--wood);
            color: white;
            transform: translateY(-2px);
        }
        /* Bảng danh sách */
        .table-wrapper {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f0e6d8;
            color: var(--wood);
            font-weight: 700;
        }
        .price {
            color: var(--gold);
            font-weight: 700;
        }
        .books-list {
            text-align: left;
            font-size: 14px;
            color: #555;
            max-width: 400px;
        }
        /* Box ẩn/hiện */
        .toggle-box {
            display: none;
            background: #fbf6ef;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px dashed var(--gold);
        }
        .rank { font-weight: bold; color: var(--gold); }
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
    <h2>📦 Quản Lý Đơn Hàng</h2>

    <div class="action-bar">
        <a href="home.php" class="btn" style="border:1px solid #3d2b1f;">⬅ Trang chủ</a>
        <button class="btn" onclick="toggleBox('bestSellerBox')">
            <i class="fa-solid fa-fire"></i> Sách bán chạy tháng <?= date('m/Y') ?>
        </button>
    </div>

    <div id="bestSellerBox" class="toggle-box">
        <h3 style="text-align:center; color: var(--wood);">🔥 TOP SÁCH BÁN CHẠY TRONG THÁNG</h3>
        <table>
            <thead>
                <tr>
                    <th>Hạng</th>
                    <th>Tên sách</th>
                    <th>Số lượng đã bán</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; while ($row = mysqli_fetch_assoc($bestSeller)): ?>
                <tr>
                    <td class="rank">#<?= $rank++ ?></td>
                    <td style="text-align:left;"><?= htmlspecialchars($row['book_name']) ?></td>
                    <td><span class="price"><?= $row['total_sold'] ?></span> cuốn</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Chi tiết sách đã mua</th>
                    <th>Ngày lập đơn</th>
                    <th>Tổng cộng</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; while ($row = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td style="font-weight:600;"><?= htmlspecialchars($row['customer_name'] ?? 'Khách lẻ') ?></td>
                    <td><?= htmlspecialchars($row['phone'] ?? '---') ?></td>
                    <td class="books-list">
                        <?= !empty($row['books']) ? htmlspecialchars($row['books']) : '<i>Đơn bán trực tiếp</i>' ?>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($row['order_date'])) ?></td>
                    <td class="price"><?= number_format($row['total_price']) ?> đ</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>