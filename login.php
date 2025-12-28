<?php
session_start();
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - BookStore</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --cream: #f4ece1;
            --wood: #3d2b1f;
            --gold: #c5a059;
            --paper: #fffcf5;
            --white-glass: rgba(255, 252, 245, 0.95);
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100vh; width: 100vw;
            background-color: var(--cream);
            font-family: 'Quicksand', sans-serif;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Lớp nền ảnh xé tĩnh */
        .bg-layer {
            position: absolute; width: 400px; height: 500px;
            background-size: cover; background-position: center;
            opacity: 0.12; z-index: 0; filter: sepia(0.5);
            clip-path: polygon(0% 10%, 15% 0%, 35% 12%, 55% 2%, 75% 15%, 100% 5%, 92% 35%, 100% 60%, 85% 95%, 60% 88%, 35% 100%, 10% 90%, 0% 75%, 8% 45%);
            pointer-events: none;
        }
        .bg-1 { top: -20px; left: -50px; background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=1000'); }
        .bg-2 { bottom: -20px; right: -50px; background-image: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80&w=1000'); }

        /* Login Box - Vết xé nghệ thuật */
        .login-box {
            position: relative; z-index: 10;
            width: 100%; max-width: 420px;
            background: var(--white-glass);
            padding: 60px 45px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            text-align: center;
            /* Cạnh trên phẳng, cạnh dưới xé nhọn */
            clip-path: polygon(0% 0%, 100% 0%, 100% 95%, 50% 100%, 0% 95%);
        }

        h2 {
            font-family: 'Cinzel Decorative', cursive;
            color: var(--wood);
            font-size: 38px;
            margin: 0;
            letter-spacing: 3px;
        }

        p.subtitle {
            color: #6a5a50;
            margin: 10px 0 35px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Input đồng bộ bo góc */
        input {
            width: 100%;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 15px; /* Bo góc mượt */
            border: 1px solid rgba(61, 43, 31, 0.15);
            background: var(--paper);
            font-size: 14px;
            font-family: 'Quicksand', sans-serif;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 10px rgba(197, 160, 89, 0.1);
        }

        /* Nút bấm bo tròn */
        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background: var(--wood);
            color: white;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(61, 43, 31, 0.2);
        }

        .error {
            background: #fbeaea;
            color: #a94442;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #ebccd1;
        }

        .back-home {
            margin-top: 30px;
            display: inline-block;
            color: var(--wood);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            opacity: 0.7;
            transition: 0.3s;
        }

        .back-home:hover {
            opacity: 1;
            color: var(--gold);
        }
    </style>
</head>

<body>

    <div class="bg-layer bg-1"></div>
    <div class="bg-layer bg-2"></div>

    <div class="login-box">
        <h2>BOOKSTORE</h2>
        <p class="subtitle">Đăng nhập hệ thống</p>

        <?php if ($error): ?>
            <div class="error">
                <i class="fa-solid fa-circle-exclamation"></i> 
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="process_login.php" method="post">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">TRUY CẬP HỆ THỐNG</button>
        </form>

        <a href="index.php" class="back-home">
            <i class="fa-solid fa-arrow-left"></i> QUAY VỀ TRANG CHỦ
        </a>
    </div>

</body>
</html>