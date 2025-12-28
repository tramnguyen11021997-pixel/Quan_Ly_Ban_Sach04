<?php
session_start();
$username = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BookStore - Pure Experience</title>

<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Quicksand:wght@300;500&display=swap" rel="stylesheet">

<style>
:root {
    --cream: #fbf8f4;
    --wood: #1a1a1a;
    --gold: #c5a059;
}

* { box-sizing: border-box; transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1); }
body, html { margin:0; padding:0; height: 100%; background:var(--cream); font-family:'Quicksand',sans-serif; overflow: hidden; }


nav { 
    position: fixed; 
    top: 0; width: 100%; 
    padding: 40px 60px; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    z-index: 100; 
}
.logo { font-family: 'Cinzel Decorative', cursive; font-size: 24px; letter-spacing: 6px; color: var(--wood); font-weight: 700; text-decoration: none; }
.admin-link { text-decoration: none; color: var(--wood); font-size: 11px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; border-bottom: 1px solid var(--wood); padding-bottom: 4px; }
.admin-link:hover { color: var(--gold); border-color: var(--gold); }

main { 
    display: flex; 
    height: 100vh; 
    width: 100vw; 
    align-items: center; 
    justify-content: center; 
    padding: 0 5vw;
}

.visual-container { 
    display: flex; 
    width: 100%; 
    height: 70vh; 
    gap: 20px; 
}

.pane { 
    flex: 1; 
    border-radius: 5px; 
    overflow: hidden; 
    position: relative;
    box-shadow: 0 30px 60px rgba(0,0,0,0.05);
}

.pane:nth-child(2) { flex: 1.5; transform: translateY(-30px); } /* Khối giữa cao hơn tạo nhịp điệu */

.img-bg { 
    width: 100%; 
    height: 100%; 
    background-size: cover; 
    background-position: center; 
    filter: grayscale(0.2) sepia(0.2); 
}

.pane:hover .img-bg { transform: scale(1.1); filter: grayscale(0); }

.floating-title {
    position: absolute;
    bottom: 15vh;
    left: 60px;
    z-index: 10;
    pointer-events: none;
}

.floating-title h1 { 
    font-family: 'Cinzel Decorative', cursive; 
    font-size: clamp(30px, 4vw, 60px); 
    color: var(--wood); 
    margin: 0; 
    line-height: 0.9;
    opacity: 0.9;
}

.floating-title p { 
    font-size: 14px; 
    letter-spacing: 8px; 
    text-transform: uppercase; 
    margin-top: 20px; 
    color: var(--gold); 
}

.abstract-circle {
    position: absolute;
    width: 400px;
    height: 400px;
    border: 1px solid rgba(197, 160, 89, 0.2);
    border-radius: 50%;
    top: -100px;
    right: -100px;
    z-index: 1;
}

</style>
</head>
<body>

<nav>
    <a href="#" class="logo">BOOKSTORE</a>
    <div class="nav-auth">
        <?php if ($username): ?>
            <a href="admin/home.php" class="admin-link">VÀO HỆ THỐNG</a>
        <?php else: ?>
            <a href="login.php" class="admin-link">Access</a>
        <?php endif; ?>
    </div>
</nav>

<div class="abstract-circle"></div>

<main>
    <div class="visual-container">
        <div class="pane">
            <div class="img-bg" style="background-image: url('https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=1200');"></div>
        </div>
        
        <div class="pane">
            <div class="img-bg" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1200');"></div>
        </div>
        
        <div class="pane">
            <div class="img-bg" style="background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1200');"></div>
        </div>
    </div>
</main>

<div class="floating-title">
    <h1>MANAGEMENT<br>SYSTEM</h1>
    <p>Established 2025</p>
</div>

</body>
</html>