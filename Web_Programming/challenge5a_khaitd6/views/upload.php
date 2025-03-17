<?php include '../config/session.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload bài làm</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Nộp bài tập</h2>
    <form action="../controllers/assignment.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="assignment_id" value="<?php echo $_GET['id']; ?>">
        <input type="file" name="submission_file" required>
        <button type="submit" name="submit_assignment">Nộp bài</button>
    </form>
</body>
</html>
