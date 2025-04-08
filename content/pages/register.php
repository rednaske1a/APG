
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
