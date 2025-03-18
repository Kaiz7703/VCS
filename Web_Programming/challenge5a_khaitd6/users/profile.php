<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Handle avatar upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $target_dir = "../uploads/avatars/";
        $file_extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $avatar = $file_name;
            $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, avatar = ? WHERE id = ?");
            $stmt->execute([$email, $phone, $avatar, $_SESSION['user_id']]);
        }
    } else {
        $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$email, $phone, $_SESSION['user_id']]);
    }
    
    $success = "Profile updated successfully";
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>My Profile</h2>
    <?php if (isset($success)): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" value="<?php echo $user['username']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" value="<?php echo $user['fullname']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $user['phone']; ?>">
        </div>
        <div class="form-group">
            <label>Avatar:</label>
            <input type="file" name="avatar">
        </div>
        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>
