<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $booking_id = (int) $_GET['id'];
    $action = $_GET['action'];
    $new_status = null;

    if ($action === 'confirm') $new_status = 'confirmed';
    if ($action === 'cancel') $new_status = 'cancelled';

    if ($new_status) {
        $update = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $update->bind_param("si", $new_status, $booking_id);
        $update->execute();
    }
    header("Location: bookings.php");
    exit();
}

$query = "SELECT bookings.id, users.name as user_name, bookings.package_name, bookings.num_people, bookings.hotel_name, bookings.total_price, bookings.booking_date, bookings.status 
          FROM bookings 
          JOIN users ON bookings.user_id = users.id
          ORDER BY bookings.id DESC";
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
                        <th>People</th>
                        <th>Hotel</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['package_name']); ?></td>
                                <td><?php echo (int) $row['num_people']; ?></td>
                                <td><?php echo $row['hotel_name'] ? htmlspecialchars($row['hotel_name']) : '—'; ?></td>
                                <td>$<?php echo number_format($row['total_price'], 0); ?></td>
                                <td><?php echo $row['booking_date']; ?></td>
                                <td>
                                    <span style="padding:0.25rem 0.6rem; border-radius:6px; font-size:0.82rem; font-weight:600;
                                        background:<?php echo $row['status'] === 'confirmed' ? '#d4edda' : ($row['status'] === 'cancelled' ? '#fde8e8' : '#fff3cd'); ?>;
                                        color:<?php echo $row['status'] === 'confirmed' ? '#155724' : ($row['status'] === 'cancelled' ? '#b02a2a' : '#856404'); ?>;">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'pending'): ?>
                                        <a href="bookings.php?action=confirm&id=<?php echo $row['id']; ?>" style="color:#155724; text-decoration:none; font-weight:600; margin-right:0.6rem;" onclick="return confirm('Confirm this booking?');">Confirm</a>
                                        <a href="bookings.php?action=cancel&id=<?php echo $row['id']; ?>" style="color:#b02a2a; text-decoration:none; font-weight:600;" onclick="return confirm('Cancel this booking?');">Cancel</a>
                                    <?php else: ?>
                                        <span style="color:#aaa; font-size:0.85rem;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>