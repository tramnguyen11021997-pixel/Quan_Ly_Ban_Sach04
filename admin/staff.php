<?php
session_start();
require_once '../includes/db.php';

/* 0. THIẾT LẬP TIẾNG VIỆT (BẮT BUỘC ĐỂ TÌM KIẾM ĐƯỢC CÓ DẤU) */
mysqli_set_charset($conn, 'utf8mb4');

/* 1. XỬ LÝ XÓA */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); 
    if (mysqli_query($conn, "DELETE FROM staff WHERE id = $id")) {
        header("Location: staff.php?msg=deleted");
        exit();
    }
}

/* 2. TRUY VẤN & TÌM KIẾM */
// Lấy giá trị và xử lý khoảng trắng thừa
$search = isset($_GET['search']) ? trim(mysqli_real_escape_string($conn, $_GET['search'])) : '';

// Xây dựng câu lệnh SQL rõ ràng
$sql = "SELECT * FROM staff WHERE 1=1"; 

if ($search !== '') {
    // Tìm kiếm mở rộng: Tên, Số điện thoại hoặc Tài khoản
    $sql .= " AND (fullname LIKE '%$search%' 
                OR phone LIKE '%$search%' 
                OR username LIKE '%$search%')";
}

$sql .= " ORDER BY id ASC"; 
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên - BookStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { 
            --wood: #3d2b1f; 
            --cream: #f4ece1; 
            --gold: #b8860b; 
            --white: #ffffff; 
            --border: #dee2e6; 
        }
        body { font-family: 'Quicksand', sans-serif; background: var(--cream); margin: 0; padding: 20px; color: var(--wood); }
        .container { max-width: 1100px; margin: auto; background: var(--white); padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        
        h2 { text-align: center; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px; }

        /* Style thanh tìm kiếm rõ ràng */
        .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 10px; flex-wrap: wrap; }
        .search-group { display: flex; flex: 1; min-width: 300px; max-width: 600px; gap: 8px; }
        .search-input { flex: 1; padding: 12px 20px; border-radius: 50px; border: 1px solid var(--border); outline: none; font-family: inherit; }
        .search-input:focus { border-color: var(--gold); box-shadow: 0 0 5px rgba(184, 134, 11, 0.2); }
        
        .btn { padding: 10px 22px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; border: none; transition: 0.3s; }
        .btn-search { background: var(--gold); color: white; }
        .btn-search:hover { background: #946d0a; }
        .btn-add { background: var(--wood); color: white; }
        .btn-add:hover { opacity: 0.9; }
        .btn-back { background: #fff; border: 1px solid var(--border); color: var(--wood); }
        .btn-clear { background: #f1f2f6; color: #666; }

        /* Bảng hiển thị */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; }
        th { background: #f8f9fa; padding: 15px; border-bottom: 2px solid var(--border); font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #eee; text-align: center; font-size: 15px; }
        tr:hover { background-color: #fffdf5; }
        .fullname { text-align: left; font-weight: 700; color: var(--wood); }
        
        .action-links a { font-size: 18px; margin: 0 8px; transition: 0.2s; display: inline-block; }
        .btn-edit { color: #2980b9; }
        .btn-edit:hover { transform: scale(1.2); }
        .btn-delete { color: #c0392b; }
        .btn-delete:hover { transform: scale(1.2); }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa-solid fa-users-gear"></i> Quản lý nhân viên</h2>

    <div class="action-bar">
        <a href="home.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> QUAY LẠI</a>

        <form class="search-group" method="GET" action="staff.php">
            <input type="text" name="search" class="search-input" 
                   placeholder="Nhập tên, số điện thoại hoặc tài khoản..." 
                   value="<?= htmlspecialchars($search) ?>">
            
            <button type="submit" class="btn btn-search">
                <i class="fa-solid fa-magnifying-glass"></i> TÌM KIẾM
            </button>

            <?php if($search !== ''): ?>
                <a href="staff.php" class="btn btn-clear" title="Xóa bộ lọc">
                    <i class="fa-solid fa-xmark"></i> HỦY
                </a>
            <?php endif; ?>
        </form>

        <a href="staff_add.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> THÊM MỚI</a>
    </div>

    <table>
        <thead>
            <tr>
                <th width="80">STT</th>
                <th style="text-align:left;">HỌ TÊN</th>
                <th>CHỨC VỤ</th>
                <th>SỐ ĐIỆN THOẠI</th>
                <th>TÀI KHOẢN</th>
                <th width="120">THAO TÁC</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($res) > 0): $stt = 1; ?>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td style="color: #999;">#<?= $stt++ ?></td>
                    <td class="fullname"><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><span style="background:#e9ecef; padding:3px 10px; border-radius:15px; font-size:12px; font-weight:600;"><?= htmlspecialchars($row['position']) ?></span></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td style="color: var(--gold); font-weight:600;"><?= htmlspecialchars($row['username']) ?></td>
                    <td class="action-links">
                        <a href="staff_edit.php?id=<?= $row['id'] ?>" class="btn-edit" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="staff.php?delete=<?= $row['id'] ?>" class="btn-delete" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding:50px; color:#999; font-style: italic;">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 24px; display: block; margin-bottom: 10px;"></i>
                        Không tìm thấy kết quả nào cho "<strong><?= htmlspecialchars($search) ?></strong>"
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>