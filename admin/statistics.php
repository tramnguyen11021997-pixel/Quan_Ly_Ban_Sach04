<?php
session_start();
include '../includes/db.php';

// 1. DOANH THU THEO NGÀY
$today = date('Y-m-d');
$res_day = mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders WHERE DATE(created_at) = '$today'");
$revenue_today = mysqli_fetch_assoc($res_day)['total'] ?? 0;

// 2. DOANH THU THEO THÁNG
$month = date('m');
$year = date('Y');
$res_month = mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders WHERE MONTH(created_at) = '$month' AND YEAR(created_at) = '$year'");
$revenue_month = mysqli_fetch_assoc($res_month)['total'] ?? 0;

// 3. THỐNG KÊ TỒN KHO - Lấy danh sách sách có số lượng từ 15 trở lên
// Sửa dấu < thành >=
$res_stock = mysqli_query($conn, "SELECT name, stock FROM books_temp WHERE stock >= 15 ORDER BY stock DESC");

// 4. DỮ LIỆU BIỂU ĐỒ
$chart_data = mysqli_query($conn, "SELECT DATE(created_at) as date, SUM(total_price) as total FROM orders GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
$dates = []; $totals = [];
while($row = mysqli_fetch_assoc($chart_data)) {
    $dates[] = date('d/m', strtotime($row['date']));
    $totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê tồn kho - BookStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #f8f9fa; padding: 20px; color: #333; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; border-left: 5px solid #3d2b1f; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .stat-card .value { font-size: 24px; font-weight: bold; margin: 10px 0; color: #28a745; } /* Màu xanh cho an toàn */
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .table-container { max-height: 400px; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #eee; }
        th { background: #fcfcfc; position: sticky; top: 0; }
        .high-stock { color: #28a745; font-weight: bold; } /* Màu xanh lá biểu thị đủ hàng */
        .btn-home { background: #3d2b1f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; }
    </style>
</head>
<body>

<div class="header">
    <h2>📊 BÁO CÁO DOANH THU & TỒN KHO</h2>
    <a href="home.php" class="btn-home"><i class="fa-solid fa-house"></i> Trang chủ</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <h3>DOANH THU HÔM NAY</h3>
        <div class="value"><?= number_format($revenue_today) ?> đ</div>
    </div>
    <div class="stat-card" style="border-left-color: #c5a059;">
        <h3>DOANH THU THÁNG <?= date('m/Y') ?></h3>
        <div class="value"><?= number_format($revenue_month) ?> đ</div>
    </div>
</div>

<div class="content-grid">
    <div class="box">
        <h3>Biểu đồ doanh thu 7 ngày qua</h3>
        <canvas id="revenueChart"></canvas>
    </div>

    <div class="box">
        <h3>📦 Danh sách tồn kho (Từ 15 trở lên)</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($res_stock) > 0): ?>
                        <?php while($s = mysqli_fetch_assoc($res_stock)): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['name']) ?></td>
                            <td class="high-stock"><?= $s['stock'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="2" style="text-align:center;">Không có sách nào có số lượng >= 15.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_reverse($dates)) ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?= json_encode(array_reverse($totals)) ?>,
            backgroundColor: '#3d2b1f',
            borderRadius: 5
        }]
    }
});
</script>

</body>
</html>