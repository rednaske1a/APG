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
    <link 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">
          <div class="card shadow">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Ustvarite uporabniški račun</h3>
              
              <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
              <?php endif; ?>
              
              <form method="post" action="register.php">
                <div class="mb-3">
                  <label for="username" class="form-label">Uporabniško ime</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Geslo</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Ustvari račun</button>
                </div>
              </form>
              <p class="mt-3 text-center">
                Že imate račun? <a href="login.php">Prijavite se tukaj</a>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script 
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
      crossorigin="anonymous">
    </script>
  </body>
</html>
