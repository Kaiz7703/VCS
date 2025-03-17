<?php
include '../config/database.php';

// Giáo viên tạo challenge
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_challenge"])) {
    $hint = $_POST["hint"];
    $file_name = strtolower(str_replace(" ", "_", basename($_FILES["file"]["name"])));
    $file_path = "../assets/uploads/" . $file_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO challenges (file_name, hint) VALUES ('$file_name', '$hint')";
        $conn->query($sql);
    }
    header("Location: ../views/challenge.php");
    exit();
}

// Sinh viên nhập đáp án
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["answer"])) {
    $answer = strtolower(str_replace(" ", "_", $_POST["answer"]));

    $sql = "SELECT * FROM challenges WHERE file_name = '$answer'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $challenge = $result->fetch_assoc();
        $file_path = "../assets/uploads/" . $challenge["file_name"];
        echo "<pre>" . htmlspecialchars(file_get_contents($file_path)) . "</pre>";
    } else {
        echo "Sai đáp án!";
    }
}

// Lấy gợi ý challenge
$sql = "SELECT hint FROM challenges ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$hint = $result->fetch_assoc()["hint"] ?? "Chưa có thử thách nào!";
?>
