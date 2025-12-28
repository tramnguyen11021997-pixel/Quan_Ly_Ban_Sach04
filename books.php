<?php
session_start();
include 'includes/db.php';

$isAdmin = isset($_SESSION['user']); 
$category = $_GET['category'] ?? '';
$search   = $_GET['search'] ?? '';

// 1. MẢNG ICON 
$icons = [
    'VANHOC'    => '📖',
    'KYNANG'    => '🌱',
    'KINHTE'    => '💼',
    'TAMLY'     => '🧠',
    'THIEUNHI'  => '🧒',
    'GIAOKHOA'  => '📚',
    'NGOAINGU'  => '🌍',
    'CONGNGHE'  => '💻',
    'GIAODUC'   => '🎓',
    'LICHSU'    => '🏰',
    'TRIETHOC'  => '📜',
    'default'   => '🔖'
];

// 2. Xây dựng SQL
$sql = "SELECT * FROM books_temp WHERE 1";
if ($category !== '') {
    $safeCat = mysqli_real_escape_string($conn, $category);
    $sql .= " AND category='$safeCat'";
}
if ($search !== '') {
    $safeSearch = mysqli_real_escape_string($conn, $search);
    $sql .= " AND (name LIKE '%$safeSearch%' OR author LIKE '%$safeSearch%')";
}
$sql .= " ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

// 3. Lấy danh sách category
$sql_all_cats = "SELECT DISTINCT category FROM books_temp WHERE category != ''";
$result_cats = mysqli_query($conn, $sql_all_cats);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kho sách - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #f4ece1; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fffcf5; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Chỉnh sửa khoảng cách các nút bấm */
        .category-nav { 
            display: flex; 
            justify-content: center; 
            flex-wrap: wrap; 
            gap: 12px; /* Khoảng cách giữa các nút */
            margin-bottom: 30px; 
            padding: 20px;
            background: #fbf6ef;
            border-radius: 15px;
        }

        .cat-btn { 
            display: inline-flex; 
            align-items: center; 
            padding: 10px 20px; 
            background: #fff; 
            color: #3d2b1f; 
            text-decoration: none; 
            border-radius: 50px; 
            font-weight: 700; 
            font-size: 13px;
            border: 1px solid #ddd;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .cat-btn i, .cat-btn span.icon { 
            margin-right: 10px !important;
            font-size: 16px;
        }

        .cat-btn:hover, .cat-btn.active { background: #3d2b1f; color: #fff; transform: translateY(-2px); }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: center; }
        th { background: #f0e6d8; }
        .btn { padding: 10px 20px; border-radius: 30px; text-decoration: none; display: inline-block; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h2 style="text-align:center; font-family:serif;">🏰 QUẢN LÝ KHO SÁCH</h2>

    <div class="category-nav">
        <a href="books.php" class="cat-btn <?= ($category == '') ? 'active' : '' ?>">
            <span class="icon">✨</span> TẤT CẢ SÁCH
        </a>
        
        <?php 
        if(mysqli_num_rows($result_cats) > 0):
            while($c = mysqli_fetch_assoc($result_cats)): 
                $name = $c['category'];
                $key = strtoupper($name); 
                $display_icon = isset($icons[$key]) ? $icons[$key] : $icons['default'];
        ?>
            <a href="books.php?category=<?= urlencode($name) ?>" 
               class="cat-btn <?= ($category == $name) ? 'active' : '' ?>">
               <span class="icon"><?= $display_icon ?></span> <?= htmlspecialchars($name) ?>
            </a>
        <?php 
            endwhile; 
        endif;
        ?>
    </div>

    <div style="text-align:center; margin-bottom: 20px;">
        <form action="books.php" method="GET">
            <input type="text" name="search" placeholder="Tìm tên sách..." style="padding:10px; border-radius:20px; border:1px solid #ccc; width:300px;">
            <button type="submit" style="padding:10px 20px; border-radius:20px; background:#3d2b1f; color:white; border:none; cursor:pointer;">Tìm kiếm</button>
        </form>
    </div>

    <div style="display:flex; justify-content: space-between; margin-bottom: 20px;">
        <a href="admin/home.php" class="btn" style="border:1px solid #3d2b1f;">⬅ Trang chủ</a>
        <?php if($isAdmin): ?>
            <a href="books_add.php" class="btn" style="background:#3d2b1f; color:white;">+ Thêm sách mới</a>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên tác phẩm</th>
                <th>Tác giả</th>
                <th>Giá niêm yết</th>
                <th>Phân loại</th>
                <?php if($isAdmin): ?><th>Thao tác</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = 1;
            while($row = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?= $stt++ ?></td>
                <td style="text-align:left;"><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= number_format($row['price']) ?> đ</td>
                <td><span style="color:#c5a059; font-weight:bold;"><?= htmlspecialchars($row['category']) ?></span></td>
                <?php if($isAdmin): ?>
                <td>
                    <a href="books_edit.php?id=<?= $row['id'] ?>" style="text-decoration:none;">✏️</a>
                    <a href="books_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Xóa sách này?')" style="text-decoration:none; margin-left:10px;">🗑️</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>