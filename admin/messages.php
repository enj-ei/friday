<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Messages - Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        .msg-card { background: #fff; padding: 1.2rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.08); }
        .msg-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
        .msg-header strong { color: #2c3e50; }
        .msg-header span { color: #888; font-size: 0.85rem; }
        .msg-email { color: #e67e22; font-size: 0.9rem; margin-bottom: 0.6rem; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2 style="color: #e67e22; margin-bottom: 2rem;">Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="packages.php">Manage Packages</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <h1>Contact Messages</h1>
            <br>
            <?php if ($messages && $messages->num_rows > 0): ?>
                <?php while($m = $messages->fetch_assoc()): ?>
                    <div class="msg-card">
                        <div class="msg-header">
                            <strong><?php echo htmlspecialchars($m['name']); ?></strong>
                            <span><?php echo htmlspecialchars($m['created_at']); ?></span>
                        </div>
                        <div class="msg-email"><?php echo htmlspecialchars($m['email']); ?></div>
                        <p><?php echo nl2br(htmlspecialchars($m['message'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No messages received yet.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
