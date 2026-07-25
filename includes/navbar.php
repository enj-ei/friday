<nav class="navbar">
    <div class="logo">
        <a href="index.php">Tive<span>Travels</span></a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php#home">Home</a></li>
        <li><a href="index.php#about">About</a></li>
        <li><a href="index.php#destinations">Destinations</a></li>
        <li><a href="index.php#packages">Packages</a></li>
        <li><a href="index.php#gallery">Gallery</a></li>
        <li><a href="index.php#reviews">Reviews</a></li>
        <li><a href="index.php#contact">Contact</a></li>
    </ul>
    <div class="nav-auth">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-menu">
                <button class="user-menu-trigger" id="userMenuTrigger">
                    <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                    <span class="user-name-label"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <span class="user-chevron">▾</span>
                </button>
                <div class="user-menu-dropdown" id="userMenuDropdown">
                    <a href="profile.php#bookings">📖 My Bookings</a>
                    <a href="profile.php">👤 My Profile</a>
                    <div class="user-menu-divider"></div>
                    <a href="logout.php" class="logout-link">🚪 Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-register">Register</a>
        <?php endif; ?>
    </div>
</nav>
