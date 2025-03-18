<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->query("SELECT id, username, fullname, email, phone, avatar, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Users List</h2>
    
    <div class="users-list">
        <?php foreach ($users as $user): ?>
            <div class="user-item">
                <div class="user-avatar">
                    <?php if ($user['avatar']): ?>
                        <img src="/uploads/avatars/<?php echo $user['avatar']; ?>" alt="Avatar">
                    <?php else: ?>
                        <img src="/assets/images/default-avatar.png" alt="Default Avatar">
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <h4><?php echo htmlspecialchars($user['fullname']); ?> (<?php echo $user['role']; ?>)</h4>
                    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
                    <a href="/messages/view.php?user_id=<?php echo $user['id']; ?>" class="btn">Send Message</a>
                    <?php if ($_SESSION['role'] === 'teacher'): ?>
                        <a href="/users/edit.php?id=<?php echo $user['id']; ?>" class="btn">Edit User</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
