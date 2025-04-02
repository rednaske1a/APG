<?php
session_start();
require 'db.php';

$user = null; // Initialize $user to null
$page = "home"; // Default page

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    // Uncomment the following lines if you want to redirect to login page when user is not logged in
    // header("Location: login.php");
    // exit;
}

?>
<!DOCTYPE html>
<html lang="si">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>APG</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>

    <div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none" style="font-size: 1.5rem; font-weight: bold;">
          apg.si
        </a>
      </div>

      <!-- when a page is accesed $page changes to the name of the page -->
      <?php if (isset($_GET['page'])): ?>
        <?php $page = htmlspecialchars($_GET['page']); ?>
      <?php endif; ?>
      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php?page=home" class="nav-link px-2 link-body-emphasis">Home</a></li>
        <li><a href="index.php?page=chat" class="nav-link px-2 link-body-emphasis">Chat</a></li>
        <li><a href="index.php?page=casino" class="nav-link px-2 link-body-emphasis">Casino</a></li>
        <li><a href="index.php?page=about" class="nav-link px-2 link-body-emphasis">About</a></li>
      </ul>

      <?php if (isset($user)): ?>
        <div class="col-md-3 text-end">
            <span class="text-body-secondary">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</span>
            <button type="button" class="btn btn-outline-primary me-2">Profile</button>
            <button type="button" class="btn btn-primary">Settings</button>
        </div>
      <?php else: ?>
        <div class="col-md-3 text-end">
            <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
            <a href="register.php"><button type="button" class="btn btn-primary">Sign-up</button></a>
        </div>
      <?php endif; ?>
    </header>

    <div class="content">
      <?php if ($page == "home"): ?>
        <h1>Welcome to APG</h1>
        <p>This is the home page.</p>
      <?php elseif ($page == "chat"): ?>
        <h1>Chat Page</h1>
        <p>This is the chat page.</p>
      <?php elseif ($page == "casino"): ?>
        <h1>Casino Page</h1>
        <p>This is the casino page.</p>
      <?php elseif ($page == "about"): ?>
        <h1>About Page</h1>
        <p>This is the about page.</p>
      <?php endif; ?>
      <a href="logout.php" style="color:blue">Logout</a>
    </div>




        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
          <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" style="font-size: 1.5rem; font-weight: bold;">
              apg.si
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© 2025 apg.si </span>
          </div>

          <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#">X</a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#">Instagram</a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#">Facebook</a></li>
          </ul>
        </footer>

    </div>
    







        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
