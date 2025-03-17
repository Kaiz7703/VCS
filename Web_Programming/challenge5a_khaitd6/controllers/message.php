<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send_message"])) {
    $sender_id = $_SESSION["user_id"];
    $receiver_id = $_POST["receiver_id"];
    $content = $_POST["content"];

    $sql = "INSERT INTO messages (sender_id, receiver_id, content) 
            VALUES ('$sender_id', '$receiver_id', '$content')";
    $conn->query($sql);
    header("Location: ../views/messages.php?user_id=$receiver_id");
    exit();
}

if (isset($_GET["delete"])) {
    $message_id = $_GET["delete"];
    $sql = "DELETE FROM messages WHERE id = '$message_id'";
    $conn->query($sql);
    header("Location: ../views/messages.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM messages WHERE receiver_id = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>

