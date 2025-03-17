<?php
session_start();

define("BASE_URL", "http://localhost/class_management/");

// Kiểm tra đăng nhập
function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

// Kiểm tra vai trò người dùng
function isTeacher() {
    return isset($_SESSION["role"]) && $_SESSION["role"] === "teacher";
}

function isStudent() {
    return isset($_SESSION["role"]) && $_SESSION["role"] === "student";
}

// Redirect nếu chưa đăng nhập
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "views/login.php");
        exit();
    }
}
?>
