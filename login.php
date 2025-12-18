<?php
session_start();
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - BookStore</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #f3e9dc, #e6d3b3);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 420px;
            background: rgba(255,255,255,0.9);
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            text-align: center;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: #4b2e23;
            font-size: 36px;
            margin-bottom: 8px;
        }

        p.subtitle {
            color: #6a5a50;
            margin-bottom: 28px;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 16px;
            border-radius: 14px;
            border: 1px solid #d8c8b2;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #8b5e34;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: #8b5e34;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #6e4524;
            transform: translateY(-2px);
        }

        .error {
            background: #fbeaea;
            color: #a94442;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .back-home {
            margin-top: 22px;
            display: block;
            color: #8b5e34;
            text-decoration: none;
            font-size: 14px;
        }

        .back-home:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>BookStore</h2>
    <p class="subtitle">Đăng nhập hệ thống</p>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="process_login.php" method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>

    <a href="index.php" class="back-home">← Quay về trang chủ</a>
</div>

</body>
</html>
