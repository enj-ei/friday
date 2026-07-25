cd ~/Documents/friday
cat > booking.php << 'EOF'
<?php
session_start();
include 'includes/connection.php';

$error = "";
$selected_package = isset($_GET['package']) ? (int) $_GET['package'] : 0;

if (isset($_POST['book_now'])) {
    $package_id = (int) $_POST['package_id'];
    $booking_date = $_POST['booking_date'];

    if ($package_id <= 0 || empty($booking_date)) {
        $error = "Please select a package and a date.";
    } else {
        $stmt = $conn->prepare("SELECT name FROM packages WHERE id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $pkg_result = $stmt->get_result();

        if ($pkg_result->num_rows === 0) {
            $error = "Selected package not found.";
        } else {
            $package_name = $pkg_result->fetch_assoc()['name'];

            if (!isset($_SESSION['user_id'])) {
                $_SESSION['pending_booking'] = [
                    'package_name' => $package_name,
                    'booking_date' => $booking_date
                ];
                header("Location: login.php");
                exit();
            } else {
                $user_id = $_SESSION['user_id'];
                $insert = $conn->prepare("INSERT INTO bookings (user_id, package_name, booking_date, status) VALUES (?, ?, ?, 'pending')");
                $insert->bind_param("iss", $user_id, $package_name, $booking_date);
                if ($insert->execute()) {
                    header("Location: profile.php?booked=1");
                    exit();
                } else {
                    $error = "Something went wrong while saving your booking.";
                }
            }
        }
    }
}

$packages = $conn->query("SELECT id, name, duration, price FROM packages ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Trek - Tive Travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body { background: #f4f6f7; }
        .booking-container {
            max-width: 520px; margin: 4rem auto; padding: 2.5rem;
            background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-radius: 12px; border-top: 4px solid #e67e22;
        }
        .booking-container h2 { margin-bottom: 0.4rem; text-align: center; color: #1a252f; font-size: 1.6rem; }
        .booking-subtitle { text-align: center; color: #888; margin-bottom: 1.8rem; font-size: 0.95rem; }
        .selected-banner {
            background: #fef3e7; border: 1px solid #f3c98b; color: #b35c00;
            padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;
            font-weight: 600; text-align: center; font-size: 0.95rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500; font-size: 0.92rem; }
        .form-group select, .form-group input {
            width: 100%; padding: 0.7rem 0.8rem; border: 1.5px solid #ddd; border-radius: 8px;
            font-size: 0.95rem; transition: border-color 0.2s ease;
        }
        .form-group select:focus, .form-group input:focus {
            outline: none; border-color: #e67e22;
        }
        .btn-submit {
            width: 100%; padding: 0.85rem; background: #e67e22; color: #fff; border: none;
            border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem;
            transition: background 0.2s ease;
        }
        .btn-submit:hover { background: #d35400; }
        .msg {
            color: #b02a2a; text-align: center; margin-bottom: 1.2rem;
            background: #fde8e8; padding: 0.6rem; border-radius: 6px; font-size: 0.9rem;
        }
        .note { font-size: 0.85rem; color: #999; text-align: center; margin-top: 1.2rem; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="booking-container">
        <h2>Book a Trekking Package</h2>
        <p class="booking-subtitle">Confirm your details and we'll take care of the rest</p>
        <?php if ($error): ?><p class="msg"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
        <?php if ($selected_package > 0):
            $sel_stmt = $conn->prepare("SELECT name FROM packages WHERE id = ?");
            $sel_stmt->bind_param("i", $selected_package);
            $sel_stmt->execute();
            $sel_row = $sel_stmt->get_result()->fetch_assoc();
            if ($sel_row):
        ?>
            <div class="selected-banner">You're booking: <?php echo htmlspecialchars($sel_row['name']); ?></div>
        <?php endif; endif; ?>

        <?php if ($packages && $packages->num_rows > 0): ?>
        <form method="POST" action="booking.php">
            <?php if ($selected_package > 0): ?>
                <input type="hidden" name="package_id" value="<?php echo $selected_package; ?>">
                <p style="text-align:center; margin-bottom:1.2rem;">
                    <a href="index.php#packages" style="color:#e67e22; font-size:0.85rem; text-decoration:underline;">Not the right package? Choose a different one</a>
                </p>
            <?php else: ?>
            <div class="form-group">
                <label>Select Package</label>
                <select name="package_id" required>
                    <option value="">-- Choose a package --</option>
                    <?php while ($p = $packages->fetch_assoc()): ?>
                        <option value="<?php echo $p['id']; ?>">
                            <?php echo htmlspecialchars($p['name']) . " (" . htmlspecialchars($p['duration']) . " - $" . htmlspecialchars($p['price']) . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Preferred Date</label>
                <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="book_now" class="btn-submit">Reserve Now</button>
        </form>
        <p class="note">You'll be asked to log in or create an account before your booking is confirmed.</p>
        <?php else: ?>
            <p style="text-align:center; color:#666;">No packages are available to book right now. Please check back soon.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
EOF