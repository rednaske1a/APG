<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="si">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>APG</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Dobrodošli, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <a href="logout.php" style="color:blue">Logout</a>
    </body>
</html>
