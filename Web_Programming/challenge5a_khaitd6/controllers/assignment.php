<?php
include '../config/database.php';

// Giáo viên upload bài tập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_assignment"])) {
    $title = $_POST["title"];
    $file_name = basename($_FILES["file"]["name"]);
    $file_path = "../assets/uploads/" . $file_name;
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO assignments (title, file_path) VALUES ('$title', '$file_name')";
        $conn->query($sql);
    }
    header("Location: ../views/assignments.php");
    exit();
}

// Sinh viên nộp bài làm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_assignment"])) {
    $assignment_id = $_POST["assignment_id"];
    $file_name = basename($_FILES["submission_file"]["name"]);
    $file_path = "../assets/uploads/" . $file_name;
    
    if (move_uploaded_file($_FILES["submission_file"]["tmp_name"], $file_path)) {
        $sql = "INSERT INTO submissions (assignment_id, student_id, file_path) 
                VALUES ('$assignment_id', '{$_SESSION["user_id"]}', '$file_name')";
        $conn->query($sql);
    }
    header("Location: ../views/assignments.php");
    exit();
}

// Lấy danh sách bài tập
$sql = "SELECT * FROM assignments";
$result = $conn->query($sql);
$assignments = $result->fetch_all(MYSQLI_ASSOC);
?>
