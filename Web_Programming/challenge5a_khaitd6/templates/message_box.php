<?php
include '../controllers/message.php';
?>
<div class="message-box">
    <h3>Tin nhắn</h3>
    <form action="../controllers/message.php" method="post">
        <input type="hidden" name="receiver_id" value="<?= $_GET['user_id'] ?>">
        <textarea name="content" placeholder="Nhập tin nhắn..." required></textarea>
        <button type="submit" name="send_message">Gửi</button>
    </form>
    <ul>
        <?php foreach ($messages as $msg): ?>
            <li>
                <strong><?= $msg['sender_id'] ?>:</strong> <?= htmlspecialchars($msg['content']) ?>
                <a href="../controllers/message.php?delete=<?= $msg['id'] ?>">Xóa</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
