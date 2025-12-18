<?php
session_start();
$username = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>BookStore</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #f3e9dc, #e6d3b3);
            min-height: 100vh;
        }

        /* HEADER */
        header {
            background: #8b5e34;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            margin: 0;
        }

        header a {
            background: white;
            color: #8b5e34;
            padding: 10px 22px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
        }

        header a:hover {
            background: #f1e4d2;
        }

        /* BANNER */
        .banner {
            text-align: center;
            padding: 60px 20px;
        }

        .banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: #4b2e23;
            margin-bottom: 10px;
        }

        .banner p {
            font-size: 18px;
            color: #5a4a42;
        }

        /* CATEGORY */
        .categories {
            max-width: 1100px;
            margin: auto;
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .category {
            background: white;
            border-radius: 18px;
            padding: 30px 20px;
            text-align: center;
            font-size: 18px;
            color: #4b2e23;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: 0.3s;
        }

        .category:hover {
            background: #8b5e34;
            color: white;
            transform: translateY(-8px);
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 20px;
            color: #5a4a42;
            font-size: 14px;
        }
    </style>
</head>

<body>

<header>
    <h1>BookStore</h1>

    <?php if ($username): ?>
        <a href="home.php">Vào hệ thống</a>
    <?php else: ?>
        <a href="login.php">Đăng nhập</a>
    <?php endif; ?>
</header>

<section class="banner">
    <h2>Thế giới sách trong tầm tay</h2>
    <p>Khám phá hàng ngàn đầu sách hay – tri thức – kỹ năng</p>
</section>

<section class="categories">
    <div class="category">📖 Văn học</div>
    <div class="category">🧒 Thiếu nhi</div>
    <div class="category">📚 Giáo khoa</div>
    <div class="category">🧠 Kỹ năng sống</div>
    <div class="category">🌍 Ngoại ngữ</div>
    <div class="category">💼 Kinh tế</div>
</section>

<footer>
    © 2025 BookStore – Hệ thống quản lý cửa hàng sách
</footer>

</body>
</html>
