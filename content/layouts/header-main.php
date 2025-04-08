<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none" style="font-size: 1.5rem; font-weight: bold;">
            apg.si
        </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="/home" class="nav-link px-2 link-body-emphasis">Home</a></li>
    <li><a href="/chat" class="nav-link px-2 link-body-emphasis">Chat</a></li>
    </ul>

    <?php if (isset($user)): ?>
    <div class="col-md-3 text-end">
        <span class="text-body-secondary">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</span>
        <button type="button" class="btn btn-outline-primary me-2">Profile</button>
        <button type="button" class="btn btn-primary">Settings</button>
    </div>
    <?php endif; ?>
</header>