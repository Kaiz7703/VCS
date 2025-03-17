<?php include '../config/session.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chính</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Chào mừng, <?php echo $_SESSION['username']; ?>!</h2>
    <nav>
        <a href="profile.php">Thông tin cá nhân</a>
        <a href="messages.php">Tin nhắn</a>
        <a href="assignments.php">Bài tập</a>
        <a href="challenge.php">Trò chơi giải đố</a>
        <a href="../controllers/auth.php?logout=true">Đăng xuất</a>
    </nav>
</body>
</html>
