<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

// Handle challenge creation for teachers
if ($_SESSION['role'] === 'teacher' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $hint = $_POST['hint'];
    
    if (isset($_FILES['challenge']) && $_FILES['challenge']['error'] == 0) {
        $target_dir = "../uploads/challenges/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Sanitize filename to be the answer
        $original_name = pathinfo($_FILES["challenge"]["name"], PATHINFO_FILENAME);
        $file_name = preg_replace('/[^a-z0-9 ]/i', '', $original_name);
        $file_name = strtolower($file_name) . '.txt';
        $target_file = $target_dir . $file_name;
        
        if (move_uploaded_file($_FILES["challenge"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO challenges (title, hint, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $hint, $file_name]);
            $success = "Challenge created successfully";
        }
    }
}

// Get all challenges
$stmt = $conn->query("SELECT * FROM challenges ORDER BY created_at DESC");
$challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Challenges</h2>
    
    <?php if ($_SESSION['role'] === 'teacher'): ?>
        <div class="challenge-form">
            <h3>Create New Challenge</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Hint:</label>
                    <textarea name="hint" required></textarea>
                </div>
                <div class="form-group">
                    <label>Challenge File (txt):</label>
                    <input type="file" name="challenge" accept=".txt" required>
                </div>
                <button type="submit" class="btn">Create Challenge</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="challenges-list">
        <h3>Available Challenges</h3>
        <?php foreach ($challenges as $challenge): ?>
            <div class="challenge-item">
                <h4><?php echo htmlspecialchars($challenge['title']); ?></h4>
                <p>Hint: <?php echo htmlspecialchars($challenge['hint']); ?></p>
                <a href="/challenges/solve.php?id=<?php echo $challenge['id']; ?>" class="btn">Try to Solve</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
