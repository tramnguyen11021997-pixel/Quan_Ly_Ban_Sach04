<?php
session_start();

/* Kết nối CSDL */
require_once __DIR__ . '/../includes/db.php';

/* Kiểm tra đăng nhập */
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - BookStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #f4ece1;
            --wood: #3d2b1f;
            --gold: #c5a059;
            --paper: #fffcf5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--cream);
            font-family: 'Quicksand', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            width: 95%;
            max-width: 1000px;
            background: rgba(255,252,245,0.97);
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0,0,0,.15);
            text-align: center;
        }

        h1 {
            font-family: 'Cinzel Decorative', cursive;
            letter-spacing: 4px;
            margin-bottom: 10px;
            color: var(--wood);
        }

        .welcome {
            font-size: 12px;
            letter-spacing: 2px;
            background: var(--wood);
            color: var(--cream);
            display: inline-block;
            padding: 6px 16px;
            margin-bottom: 40px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: var(--paper);
            height: 180px;
            border-radius: 25px;
            border: 1px solid rgba(0,0,0,.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            transition: .3s;
        }

        .card i {
            font-size: 32px;
            color: var(--wood);
            margin-bottom: 10px;
        }

        .card span {
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--wood);
        }

        .card:hover {
            background: var(--wood);
            transform: translateY(-6px);
        }

        .card:hover i,
        .card:hover span {
            color: var(--gold);
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 8px 22px;
            border: 1px solid var(--wood);
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            color: var(--wood);
            transition: .3s;
        }

        .btn:hover {
            background: var(--wood);
            color: white;
        }

        @media (max-width: 900px) {
            .menu { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<div class="main">
    <h1>BOOKSTORE ADMIN</h1>
    <div class="welcome">XIN CHÀO • <?= htmlspecialchars($username) ?></div>

    <div class="menu">
        <a href="../books.php" class="card">
            <i class="fa-solid fa-book"></i>
            <span>QUẢN LÝ SÁCH</span>
        </a>

        <a href="customers.php" class="card">
            <i class="fa-solid fa-users"></i>
            <span>KHÁCH HÀNG</span>
        </a>

        <a href="orders.php" class="card">
            <i class="fa-solid fa-file-invoice"></i>
            <span>ĐƠN HÀNG</span>
        </a>

        <a href="stats.php" class="card">
            <i class="fa-solid fa-chart-line"></i>
            <span>THỐNG KÊ</span>
        </a>
    </div>

    <div class="footer">
        <a href="../index.php" class="btn">TRANG CHỦ WEB</a>
        <a href="../logout.php" class="btn" style="border-color:#a94444;color:#a94444;">ĐĂNG XUẤT</a>
    </div>
</div>

</body>
</html>
