hello you are inside apg

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
<h1> Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
<a href="logout.php" style="color:blue">Logout</a>