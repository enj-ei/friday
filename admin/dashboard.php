<?php
session_start();
include '../includes/connection.php';

// Quick guard to protect admin dashboard
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar h2 { margin-bottom: 2rem; font-size: 1.2rem; color: #e67e22; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        .cards { display: flex; gap: 1.5rem; margin-top: 1.5rem; }
        .card { background: #fff; padding: 1.5rem; border-radius: 6px; flex: 1; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="admin-layout">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
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
            <h1>Welcome, Admin</h1>
            <div class="cards">
                <div class="card">
                    <h3>Total Bookings</h3>
                    <p>24</p>
                </div>
                <div class="card">
                    <h3>Active Packages</h3>
                    <p>8</p>
                </div>
                <div class="card">
                    <h3>Registered Users</h3>
                    <p>112</p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>