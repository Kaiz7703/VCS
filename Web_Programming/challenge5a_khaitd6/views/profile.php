<?php include '../config/session.php'; ?>
<?php include '../controllers/user.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Thông tin người dùng</h2>
    <p>Họ và tên: <?php echo $user['full_name']; ?></p>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Số điện thoại: <?php echo $user['phone']; ?></p>
    <p>Avatar: <img src="../assets/uploads/<?php echo $user['avatar']; ?>" width="100"></p>
    <a href="messages.php?user_id=<?php echo $user['id']; ?>">Gửi tin nhắn</a>
</body>
</html>
