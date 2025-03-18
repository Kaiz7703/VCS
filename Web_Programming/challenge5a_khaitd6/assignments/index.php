<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

// Handle file upload for teachers
if ($_SESSION['role'] === 'teacher' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    if (isset($_FILES['assignment']) && $_FILES['assignment']['error'] == 0) {
        $target_dir = "../uploads/assignments/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = uniqid() . '_' . $_FILES["assignment"]["name"];
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["assignment"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO assignments (title, description, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $file_name]);
            $success = "Assignment uploaded successfully";
        }
    }
}

// Get all assignments
$stmt = $conn->query("SELECT * FROM assignments ORDER BY created_at DESC");
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Assignments</h2>
    
    <?php if ($_SESSION['role'] === 'teacher'): ?>
        <div class="assignment-form">
            <h3>Upload New Assignment</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label>File:</label>
                    <input type="file" name="assignment" required>
                </div>
                <button type="submit" class="btn">Upload Assignment</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="assignments-list">
        <h3>Available Assignments</h3>
        <?php foreach ($assignments as $assignment): ?>
            <div class="assignment-item">
                <h4><?php echo htmlspecialchars($assignment['title']); ?></h4>
                <p><?php echo htmlspecialchars($assignment['description']); ?></p>
                <a href="/uploads/assignments/<?php echo $assignment['file_path']; ?>" class="btn" download>Download Assignment</a>
                <?php if ($_SESSION['role'] === 'student'): ?>
                    <a href="/assignments/submit.php?id=<?php echo $assignment['id']; ?>" class="btn">Submit Solution</a>
                <?php else: ?>
                    <a href="/assignments/submissions.php?id=<?php echo $assignment['id']; ?>" class="btn">View Submissions</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
