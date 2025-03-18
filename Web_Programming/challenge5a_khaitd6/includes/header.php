<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/users.php">Users</a></li>
                <li><a href="/assignments.php">Assignments</a></li>
                <li><a href="/challenges.php">Challenges</a></li>
                <li><a href="/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/login.php">Login</a></li>
                <li><a href="/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
