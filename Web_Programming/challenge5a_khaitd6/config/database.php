<?php
$host = "localhost";  // Hoặc địa chỉ IP của MySQL server
$user = "root";       // Thay bằng username của MySQL
$password = "";       // Thay bằng password của MySQL
$database = "class_management"; // Tên database

$conn = new mysqli($host, $user, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
