<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "SELECT bookings.id, users.name as user_name, bookings.package_name, bookings.booking_date, bookings.status 
          FROM bookings 
          JOIN users ON bookings.user_id = users.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #34495e; color: #fff; }
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
            <h1>Customer Bookings</h1>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                <td><?php echo $row['booking_date']; ?></td>
                                <td><?php echo ucfirst($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>