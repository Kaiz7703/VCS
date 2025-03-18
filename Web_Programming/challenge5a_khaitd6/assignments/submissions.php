<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
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

// Get assignment details
$stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ?");
$stmt->execute([$assignment_id]);
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

// Get all submissions for this assignment
$stmt = $conn->prepare("
    SELECT s.*, u.fullname, u.username 
    FROM submissions s
    JOIN users u ON s.student_id = u.id
    WHERE s.assignment_id = ?
    ORDER BY s.submitted_at DESC
");
$stmt->execute([$assignment_id]);
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Submissions for: <?php echo htmlspecialchars($assignment['title']); ?></h2>
    
    <div class="submissions-list">
        <?php if (empty($submissions)): ?>
            <p>No submissions yet.</p>
        <?php else: ?>
            <?php foreach ($submissions as $submission): ?>
                <div class="submission-item">
                    <h4>Submitted by: <?php echo htmlspecialchars($submission['fullname']); ?> 
                        (<?php echo htmlspecialchars($submission['username']); ?>)</h4>
                    <p>Submitted at: <?php echo $submission['submitted_at']; ?></p>
                    <a href="/uploads/submissions/<?php echo $submission['file_path']; ?>" 
                       class="btn" download>Download Submission</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
