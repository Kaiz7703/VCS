<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Đăng ký tài khoản</h2>
    <form action="../controllers/auth.php" method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="text" name="full_name" placeholder="Họ và tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Số điện thoại">
        <select name="role">
            <option value="student">Sinh viên</option>
            <option value="teacher">Giáo viên</option>
        </select>
        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
