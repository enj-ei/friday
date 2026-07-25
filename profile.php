<?php
session_start();
include 'includes/connection.php';
include 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];
$review_status = "";

if (isset($_POST['submit_review'])) {
    $comment = trim($_POST['comment']);
    $rating = (int) $_POST['rating'];

    if ($comment === '' || $rating < 1 || $rating > 5) {
        $review_status = "error:Please write a comment and select a rating between 1 and 5.";
    } else {
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, comment, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user_id, $comment, $rating);
        if ($stmt->execute()) {
            $review_status = "success:Thank you! Your review has been posted.";
        } else {
            $review_status = "error:Something went wrong. Please try again.";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY id DESC");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$bookings_res = $stmt2->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Tive Travels</title>
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
        .review-form-card { background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .review-form-card h3 { color: #2c3e50; margin-bottom: 1rem; }
        .review-form-card .form-group { margin-bottom: 1rem; }
        .review-form-card label { display: block; margin-bottom: 0.4rem; color: #333; font-weight: 500; }
        .review-form-card select, .review-form-card textarea {
            width: 100%; padding: 0.6rem; border: 1.5px solid #ddd; border-radius: 6px; font-family: inherit; font-size: 0.95rem;
        }
        .btn-submit-review {
            background: #e67e22; color: #fff; border: none; padding: 0.65rem 1.4rem;
            border-radius: 6px; cursor: pointer; font-weight: bold;
        }
        .btn-submit-review:hover { background: #d35400; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="profile-container">
        <?php if (isset($_GET['booked']) && $_GET['booked'] == '1'): ?>
            <p style="background:#d4edda;color:#155724;padding:0.75rem;border-radius:6px;margin-bottom:1rem;">Your booking has been received! Check your booking history below.</p>
        <?php endif; ?>
        <div class="user-card">
            <h2>User Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="booking-history" id="bookings" style="margin-bottom: 2rem; scroll-margin-top: 90px;">
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
    <div class="review-form-card">
            <h3>Leave a Review</h3>
            <?php if ($review_status):
                list($rtype, $rtext) = explode(":", $review_status, 2);
            ?>
                <p style="padding:0.7rem; border-radius:6px; margin:1rem 0; font-weight:600;
                    background:<?php echo $rtype === 'success' ? '#d4edda' : '#fde8e8'; ?>;
                    color:<?php echo $rtype === 'success' ? '#155724' : '#b02a2a'; ?>;">
                    <?php echo htmlspecialchars($rtext); ?>
                </p>
            <?php endif; ?>
            <form method="POST" action="profile.php">
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rating" required>
                        <option value="">-- Select rating --</option>
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Good</option>
                        <option value="3">3 - Average</option>
                        <option value="2">2 - Poor</option>
                        <option value="1">1 - Very Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Your Review</label>
                    <textarea name="comment" rows="4" required placeholder="Tell us about your trekking experience..."></textarea>
                </div>
                <button type="submit" name="submit_review" class="btn-submit-review">Submit Review</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>