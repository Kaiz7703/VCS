<?php include '../config/session.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trò chơi giải đố</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Thử thách</h2>
    <form action="../controllers/challenge.php" method="post">
        <p>Gợi ý: <?php echo $hint; ?></p>
        <input type="text" name="answer" placeholder="Nhập đáp án..." required>
        <button type="submit">Trả lời</button>
    </form>
</body>
</html>
