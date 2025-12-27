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
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .card {
            background: #fff;
            padding: 20px 30px;
            border-radius: 18px;
            text-decoration: none;   
            color: #333;            
            font-weight: 400;
            min-width: 180px;
            text-align: center;
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            transition: 0.3s;
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

        .logout {
            display: flex;         /* Sử dụng flexbox để nằm ngang */
            justify-content: flex-end; /* Đẩy cả 2 nút về bên phải */
            gap: 15px;            /* Khoảng cách giữa 2 nút */
            margin-top: 35px;
        }

        .btn-home {
            background: #8b5e34;  /* Màu nâu sáng hơn */
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #4b2e23;
            transform: translateY(-2px);
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
        <a href="books.php" class="card">📚 Quản lý sách</a>
        <a href="customers.php" class="card">👥 Khách hàng</a>
        <a href="orders.php" class="card">🧾 Đơn hàng</a>
        <a href="stats.php" class="card">📊 Thống kê</a>
    </div>


    <div class="logout">
        <a href="index.php" class="btn-home">⬅</a>
        <a href="logout.php">Đăng xuất</a>
    </div>

</div>

</body>
</html>
