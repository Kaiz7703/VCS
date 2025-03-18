<?php
require_once 'config/database.php';
require_once 'includes/header.php';
?>

<div class="container">
    <h2>Welcome to Student Management System</h2>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dashboard">
            <h3>Quick Links</h3>
            <div class="quick-links">
                <a href="/users/list.php" class="btn">Users List</a>
                <a href="/assignments/index.php" class="btn">Assignments</a>
                <a href="/challenges/index.php" class="btn">Challenges</a>
                <a href="/users/profile.php" class="btn">My Profile</a>
            </div>
        </div>
    <?php else: ?>
        <p>Please <a href="/auth/login.php">login</a> or <a href="/auth/register.php">register</a> to continue.</p>
    <?php endif; ?>
</div>
