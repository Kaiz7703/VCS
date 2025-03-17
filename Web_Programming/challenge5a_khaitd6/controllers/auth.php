<?php
session_start();
include '../config/database.php';

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $role = $_POST["role"];

    $sql = "INSERT INTO users (username, password, full_name, email, phone, role) 
            VALUES ('$username', '$password', '$full_name', '$email', '$phone', '$role')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../views/login.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];
            header("Location: ../views/index.php");
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Tài khoản không tồn tại!";
    }
}

// Xử lý đăng xuất
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
?>
