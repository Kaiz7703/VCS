<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$to_user_id = $_GET['user_id'] ?? null;
if (!$to_user_id) {
    header('Location: /users/list.php');
    exit;
}

// Handle message operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'send') {
            $message = $_POST['message'];
            $stmt = $conn->prepare("INSERT INTO messages (from_user_id, to_user_id, message) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $to_user_id, $message]);
        } elseif ($_POST['action'] === 'delete' && isset($_POST['message_id'])) {
            $stmt = $conn->prepare("DELETE FROM messages WHERE id = ? AND from_user_id = ?");
            $stmt->execute([$_POST['message_id'], $_SESSION['user_id']]);
        } elseif ($_POST['action'] === 'edit' && isset($_POST['message_id']) && isset($_POST['edited_message'])) {
            $stmt = $conn->prepare("UPDATE messages SET message = ? WHERE id = ? AND from_user_id = ?");
            $stmt->execute([$_POST['edited_message'], $_POST['message_id'], $_SESSION['user_id']]);
        }
    }
}

// Get user details
$stmt = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
$stmt->execute([$to_user_id]);
$to_user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get messages
$stmt = $conn->prepare("
    SELECT m.*, u.fullname FROM messages m 
    JOIN users u ON m.from_user_id = u.id 
    WHERE (m.from_user_id = ? AND m.to_user_id = ?) 
    OR (m.from_user_id = ? AND m.to_user_id = ?) 
    ORDER BY m.created_at ASC
");
$stmt->execute([$_SESSION['user_id'], $to_user_id, $to_user_id, $_SESSION['user_id']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Conversation with <?php echo htmlspecialchars($to_user['fullname']); ?></h2>
    
    <div class="messages-list">
        <?php foreach ($messages as $message): ?>
            <div class="message-item <?php echo $message['from_user_id'] == $_SESSION['user_id'] ? 'sent' : 'received'; ?>">
                <p class="message-content"><?php echo htmlspecialchars($message['message']); ?></p>
                <small class="message-info">
                    From <?php echo htmlspecialchars($message['fullname']); ?> 
                    at <?php echo $message['created_at']; ?>
                </small>
                
                <?php if ($message['from_user_id'] == $_SESSION['user_id']): ?>
                    <div class="message-actions">
                        <button onclick="editMessage(<?php echo $message['id']; ?>)" class="btn">Edit</button>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                            <button type="submit" class="btn">Delete</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    <form method="POST" class="message-form">
        <input type="hidden" name="action" value="send">
        <div class="form-group">
            <textarea name="message" required></textarea>
        </div>
        <button type="submit" class="btn">Send Message</button>
    </form>
</div>

<script>
function editMessage(messageId) {
    const newMessage = prompt('Edit your message:');
    if (newMessage) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="message_id" value="${messageId}">
            <input type="hidden" name="edited_message" value="${newMessage}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
