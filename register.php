<?php
session_start();
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Izpolnite vsa polja.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Uporabniško ime že obstaja.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashedPassword])) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            } else {
                $error = "Prišlo je do napake pri registraciji.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ustvarite uporabniški račun.</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label>Uporabniško ime:
            <input type="text" name="username" required>
        </label>
        <br>
        <label>Geslo:
            <input type="password" name="password" required>
        </label>
        <br>
        <button type="submit" class="button">Ustvari</button>
    </form>

    <p>Že imate račun? <a href="login.php" style="color:blue;">Prijavite se tukaj</a>.</p>
</body>
</html>
