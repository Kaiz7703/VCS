<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$challenge_id = $_GET['id'] ?? null;
if (!$challenge_id) {
    header('Location: /challenges/index.php');
    exit;
}

// Get challenge details
$stmt = $conn->prepare("SELECT * FROM challenges WHERE id = ?");
$stmt->execute([$challenge_id]);
$challenge = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = strtolower(trim($_POST['answer']));
    $file_path = "../uploads/challenges/" . $challenge['file_path'];
    
    if (file_exists($file_path) && $answer === pathinfo($challenge['file_path'], PATHINFO_FILENAME)) {
        $content = file_get_contents($file_path);
        $success = "Correct! Here's the content:<br><pre>" . htmlspecialchars($content) . "</pre>";
    } else {
        $error = "Incorrect answer. Try again!";
    }
}
?>

<div class="container">
    <h2>Solve Challenge</h2>
    <h3><?php echo htmlspecialchars($challenge['title']); ?></h3>
    <p>Hint: <?php echo htmlspecialchars($challenge['hint']); ?></p>
    
    <?php if (isset($success)): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Your Answer:</label>
            <input type="text" name="answer" required>
        </div>
        <button type="submit" class="btn">Submit Answer</button>
    </form>
</div>
