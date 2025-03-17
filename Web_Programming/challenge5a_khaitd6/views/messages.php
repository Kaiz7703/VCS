<?php include '../config/session.php'; ?>
<?php include '../controllers/message.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin nhắn</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Hộp tin nhắn</h2>
    <form action="../controllers/message.php" method="post">
        <input type="hidden" name="receiver_id" value="<?php echo $_GET['user_id']; ?>">
        <textarea name="content" placeholder="Nhập tin nhắn..." required></textarea>
        <button type="submit" name="send_message">Gửi</button>
    </form>
    <h3>Tin nhắn đã gửi</h3>
    <ul>
        <?php foreach ($messages as $msg): ?>
            <li><?php echo $msg['content']; ?> <a href="../controllers/message.php?delete=<?php echo $msg['id']; ?>">Xóa</a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
