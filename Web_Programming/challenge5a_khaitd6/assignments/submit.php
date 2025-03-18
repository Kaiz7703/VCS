<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$assignment_id = $_GET['id'] ?? null;
if (!$assignment_id) {
    header('Location: /assignments/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['submission']) && $_FILES['submission']['error'] == 0) {
        $target_dir = "../uploads/submissions/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = uniqid() . '_' . $_FILES["submission"]["name"];
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["submission"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$assignment_id, $_SESSION['user_id'], $file_name]);
            $success = "Solution submitted successfully";
        }
    }
}

// Get assignment details
$stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ?");
$stmt->execute([$assignment_id]);
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Submit Solution</h2>
    <h3><?php echo htmlspecialchars($assignment['title']); ?></h3>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Your Solution:</label>
            <input type="file" name="submission" required>
        </div>
        <button type="submit" class="btn">Submit Solution</button>
    </form>
</div>
