<?php
session_start();
// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Kết nối Database
$conn = mysqli_connect("localhost", "root", "", "bookstore");
mysqli_set_charset($conn, "utf8");

// Xử lý tìm kiếm
$keyword = $_GET['keyword'] ?? '';
$sql = "SELECT * FROM customers WHERE 1";
if ($keyword) {
    $sql .= " AND (name LIKE '%$keyword%' OR phone LIKE '%$keyword%')";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <style>
        /* Toàn bộ CSS xử lý giao diện đẹp, không rối */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f1ea;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            background: #fff;
            max-width: 1100px;
            margin: 20px auto;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Bố cục phần đầu */
        .header-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
            margin-bottom: 30px;
        }

        .header-section h2 {
            font-size: 36px;
            color: #5a3825;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Thanh tìm kiếm chính giữa */
        .search-box {
            display: flex;
            gap: 10px;
            justify-content: center;
            width: 100%;
        }

        .search-box input {
            padding: 12px 20px;
            width: 350px;
            border: 2px solid #ddd;
            border-radius: 30px;
            outline: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .search-box input:focus {
            border-color: #8b5e34;
        }

        /* Thanh tác vụ: Trang chủ (trái) & Thêm mới (phải) */
        .action-bar {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        /* Nút bấm chung */
        .btn {
            padding: 10px 22px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-main { background: #8b5e34; color: white; }
        .btn-main:hover { background: #6e4524; transform: translateY(-2px); }

        .btn-sub { background: #fdfaf6; color: #8b5e34; border: 2px solid #8b5e34; }
        .btn-sub:hover { background: #8b5e34; color: white; }

        /* Bảng hiển thị */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th {
            background: #8b5e34;
            color: white;
            padding: 15px;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #f2f2f2;
        }

        tr:hover { background: #fcf9f5; }

        .action-links a {
            text-decoration: none;
            margin: 0 5px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <h2>👥 Quản lý khách hàng</h2>

        <form method="GET" class="search-box">
            <input type="text" name="keyword" placeholder="Nhập tên hoặc số điện thoại..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn btn-main">Tìm kiếm</button>
            <?php if($keyword): ?>
                <a href="customers.php" class="btn btn-sub">Hủy lọc</a>
            <?php endif; ?>
        </form>

        <div class="action-bar">
            <a href="home.php" class="btn btn-sub">⬅ Trang chủ</a>
            <a href="customer_add.php" class="btn btn-main">➕ Thêm khách hàng mới</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td class="action-links">
                        <a href="customer_edit.php?id=<?= $row['id'] ?>" title="Sửa">✏️</a>
                        <a href="customer_delete.php?id=<?= $row['id'] ?>" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">🗑️</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 30px; color: #999;">Không tìm thấy khách hàng nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>