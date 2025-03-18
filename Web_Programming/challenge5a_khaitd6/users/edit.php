<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    header('Location: /users/list.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            
            $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $phone, $user_id]);
            $success = "User updated successfully";
            
        } elseif ($_POST['action'] === 'delete') {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'student'");
            $stmt->execute([$user_id]);
            header('Location: /users/list.php');
            exit;
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Edit User</h2>
    
    <?php if (isset($success)): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="action" value="update">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <button type="submit" class="btn">Update User</button>
    </form>
    
    <?php if ($user['role'] === 'student'): ?>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn" style="background: #dc3545;">Delete User</button>
        </form>
    <?php endif; ?>
</div>
