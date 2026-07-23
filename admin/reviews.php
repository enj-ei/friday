<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch user reviews
$sql = "SELECT reviews.id, users.name, reviews.comment, reviews.rating, reviews.created_at 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id 
        ORDER BY reviews.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reviews - Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        .review-card { background: #fff; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
        .rating { color: #f39c12; font-weight: bold; }
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
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Customer Reviews</h1>
            <br>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                            <span class="rating">Rating: <?php echo $row['rating']; ?>/5 ★</span>
                        </div>
                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                        <small style="color: #888;"><?php echo $row['created_at']; ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No customer reviews submitted yet.</p>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>