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
        <li><a href="index.php#contact">Contact</a></li>
    </ul>
    <div class="nav-auth">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php" class="btn-login">My Profile</a>
            <a href="logout.php" class="btn-register">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-register">Register</a>
        <?php endif; ?>
    </div>
</nav>