<?php
session_start();
include 'includes/connection.php';
include 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$user_res = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
$user = $user_res->fetch_assoc();

// Get bookings for this user
$bookings_res = $conn->query("SELECT * FROM bookings WHERE user_id = '$user_id' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Trekking Adventure</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .profile-container { max-width: 900px; margin: 3rem auto; padding: 0 5%; }
        .user-card { background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .user-card h2 { color: #2c3e50; margin-bottom: 0.5rem; }
        .booking-history { background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #1a252f; color: #fff; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="profile-container">
        <div class="user-card">
            <h2>User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="booking-history">
            <h3>My Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package Name</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookings_res && $bookings_res->num_rows > 0): ?>
                        <?php while($b = $bookings_res->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $b['id']; ?></td>
                                <td><?php echo htmlspecialchars($b['package_name']); ?></td>
                                <td><?php echo $b['booking_date']; ?></td>
                                <td><?php echo ucfirst($b['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No active bookings found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>