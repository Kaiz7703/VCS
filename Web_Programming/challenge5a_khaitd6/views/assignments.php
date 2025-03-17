<?php include '../config/session.php'; ?>
<?php include '../controllers/assignment.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài tập</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Danh sách bài tập</h2>
    <ul>
        <?php foreach ($assignments as $assignment): ?>
            <li>
                <?php echo $assignment['title']; ?>
                <a href="../assets/uploads/<?php echo $assignment['file_path']; ?>" download>Tải xuống</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
