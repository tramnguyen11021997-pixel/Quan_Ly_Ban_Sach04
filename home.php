<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>BookStore – Trang quản lý</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #f3e9dc, #e6d3b3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard {
            width: 85%;
            max-width: 1100px;
            background: rgba(255,255,255,0.95);
            border-radius: 28px;
            padding: 45px 50px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #4b2e23;
            font-size: 42px;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #6a5a50;
            margin-bottom: 30px;
        }

        .success {
            background: linear-gradient(120deg, #8b5e34, #6e4524);
            color: white;
            padding: 18px 24px;
            border-radius: 18px;
            margin-bottom: 35px;
            font-size: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        .success b {
            font-size: 18px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .card {
            background: #fff;
            padding: 28px 20px;
            border-radius: 20px;
            text-align: center;
            font-size: 16px;
            color: #4b2e23;
            cursor: pointer;
            transition: 0.35s;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card:hover {
            background: #8b5e34;
            color: #fff;
            transform: translateY(-6px) scale(1.03);
        }

        .logout {
            text-align: right;
            margin-top: 35px;
        }

        .logout a {
            background: #6e4524;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .logout a:hover {
            background: #4b2e23;
        }

        @media (max-width: 900px) {
            .menu {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

<div class="dashboard">

    <h1>BookStore</h1>
    <p class="subtitle">Hệ thống quản lý cửa hàng sách</p>

    <!-- ĐĂNG NHẬP THÀNH CÔNG -->
    <div class="success">
        🎉 Đăng nhập thành công! <br>
        Xin chào <b><?php echo htmlspecialchars($username); ?></b> – chúc bạn làm việc hiệu quả 📚
    </div>

    <!-- MENU -->
    <div class="menu">
        <div class="card">📚 Quản lý sách</div>
        <div class="card">🧑‍🤝‍🧑 Khách hàng</div>
        <div class="card">🧾 Đơn hàng</div>
        <div class="card">📊 Thống kê</div>
    </div>

    <div class="logout">
        <a href="logout.php">Đăng xuất</a>
    </div>

</div>

</body>
</html>
