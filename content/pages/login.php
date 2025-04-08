
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-5">
          <div class="card shadow">
            <div class="card-body">
              <h3 class="card-title text-center mb-4">Login</h3>
              <form method="post" action="login.php">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>
              <p class="mt-3 text-center">
                Don't have an account? <a href="register.php">Register here</a>.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>