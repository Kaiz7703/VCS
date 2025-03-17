<?php if (isset($_SESSION["user_id"])): ?>
<nav>
    <ul>
        <li><a href="../views/index.php">Trang chủ</a></li>
        <li><a href="../views/users.php">Danh sách người dùng</a></li>
        <li><a href="../views/assignments.php">Bài tập</a></li>
        <li><a href="../views/challenge.php">Challenge</a></li>
        <li><a href="../controllers/auth.php?logout=true">Đăng xuất</a></li>
    </ul>
</nav>
<?php else: ?>
<nav>
    <ul>
        <li><a href="../views/login.php">Đăng nhập</a></li>
        <li><a href="../views/register.php">Đăng ký</a></li>
    </ul>
</nav>
<?php endif; ?>
