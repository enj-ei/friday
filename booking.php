<?php
session_start();
include 'includes/connection.php';

$package_id = isset($_GET['package']) ? (int) $_GET['package'] : (isset($_POST['package_id']) ? (int) $_POST['package_id'] : 0);

if ($package_id <= 0) {
    header("Location: index.php#packages");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

if (!$package) {
    header("Location: index.php#packages");
    exit();    
}

$error = "";
$hotels = $conn->query("SELECT * FROM hotels ORDER BY price_per_night ASC");

if (isset($_POST['confirm_booking'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $num_people = max(1, (int) $_POST['num_people']);
    $booking_date = $_POST['booking_date'];

    $hotel_id = isset($_POST['hotel_id']) ? (int) $_POST['hotel_id'] : 0;
    $nights = isset($_POST['nights']) ? max(0, (int) $_POST['nights']) : 0;
    $hotel_name = null;
    $accommodation_total = 0;

    if ($hotel_id > 0 && $nights > 0) {
        $hstmt = $conn->prepare("SELECT name, price_per_night FROM hotels WHERE id = ?");
        $hstmt->bind_param("i", $hotel_id);
        $hstmt->execute();
        $hrow = $hstmt->get_result()->fetch_assoc();
        if ($hrow) {
            $hotel_name = $hrow['name'];
            $accommodation_total = $hrow['price_per_night'] * $nights;
        }
    }

    $total_price = ($package['price'] * $num_people) + $accommodation_total;

    if ($full_name === '' || $email === '' || $booking_date === '') {
        $error = "Please fill in your name, email, and travel date.";
    } else {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['pending_booking'] = [
                'package_name' => $package['name'],
                'num_people' => $num_people,
                'phone' => $phone,
                'hotel_name' => $hotel_name,
                'nights' => $nights,
                'accommodation_total' => $accommodation_total,
                'total_price' => $total_price,
                'booking_date' => $booking_date
            ];
            header("Location: login.php");
            exit();
        } else {
            $user_id = $_SESSION['user_id'];
            $insert = $conn->prepare("INSERT INTO bookings (user_id, package_name, num_people, phone, hotel_name, nights, accommodation_total, total_price, booking_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            $insert->bind_param("isissiids", $user_id, $package['name'], $num_people, $phone, $hotel_name, $nights, $accommodation_total, $total_price, $booking_date);
            if ($insert->execute()) {
                header("Location: profile.php?booked=1");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}

$prefill_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$prefill_email = '';
if (isset($_SESSION['user_id'])) {
    $u = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $u->bind_param("i", $_SESSION['user_id']);
    $u->execute();
    $urow = $u->get_result()->fetch_assoc();
    if ($urow) $prefill_email = $urow['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($package['name']); ?> - Tive Travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .hero-banner {
            position: relative; height: 480px; background-size: cover; background-position: center;
            background-image: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0.15)), url('https://picsum.photos/1400/600?random=<?php echo $package['id'] + 100; ?>');
            color: #fff; display: flex; align-items: flex-end;
        }
        .hero-inner { padding: 0 5% 2.5rem; width: 100%; max-width: 1300px; margin: 0 auto; }
        .back-link { color: #fff; text-decoration: none; font-size: 0.9rem; display: inline-block; margin-bottom: 1rem; opacity: 0.9; }
        .back-link:hover { text-decoration: underline; }
        .hero-badges { margin-bottom: 0.8rem; }
        .hero-badge { display: inline-block; padding: 0.35rem 0.9rem; border-radius: 999px; font-size: 0.8rem; font-weight: 700; margin-right: 0.5rem; }
        .hero-badge.category { background: #e67e22; color: #fff; }
        .hero-badge.featured { background: #f1c40f; color: #4a3800; }
        .hero-inner h1 { font-size: 2.6rem; margin-bottom: 0.7rem; }
        .hero-meta { display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.95rem; opacity: 0.95; }

        .detail-layout { max-width: 1300px; margin: 0 auto; padding: 3rem 5%; display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap; }
        .detail-main { flex: 2; min-width: 300px; }
        .detail-main h2 { color: #2c3e50; margin-bottom: 1rem; }
        .detail-main p.about-text { color: #555; line-height: 1.7; margin-bottom: 2rem; }
        .highlights-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
        .highlight-box { background: #f4efe8; padding: 1.1rem 1.3rem; border-radius: 8px; display: flex; align-items: flex-start; gap: 0.8rem; }
        .highlight-box .icon { color: #e67e22; font-size: 1.2rem; margin-top: 0.1rem; }
        .highlight-box strong { display: block; color: #2c3e50; margin-bottom: 0.2rem; }
        .highlight-box span { color: #777; font-size: 0.9rem; }

        .booking-sidebar { flex: 1; min-width: 300px; position: sticky; top: 90px; background: #fff; border-radius: 10px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .price-header { background: #e67e22; color: #fff; padding: 1.2rem 1.5rem; font-size: 1.5rem; font-weight: 700; }
        .price-header span { font-size: 0.9rem; font-weight: 400; opacity: 0.9; }
        .booking-form-body { padding: 1.5rem; }
        .booking-form-body .form-group { margin-bottom: 1.1rem; }
        .booking-form-body label { display: block; margin-bottom: 0.4rem; color: #333; font-size: 0.9rem; font-weight: 500; }
        .booking-form-body input, .booking-form-body select {
            width: 100%; padding: 0.65rem 0.8rem; border: 1.5px solid #ddd; border-radius: 8px; font-size: 0.95rem;
        }
        .qty-stepper { display: flex; align-items: center; gap: 1rem; }
        .qty-btn {
            width: 36px; height: 36px; border-radius: 6px; border: 1.5px solid #ddd; background: #fff;
            font-size: 1.1rem; cursor: pointer;
        }
        .qty-value { font-weight: 700; font-size: 1.05rem; min-width: 20px; text-align: center; }
        .price-divider { border-top: 1px solid #eee; margin: 1.2rem 0; }
        .total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.2rem; }
        .total-row span:first-child { color: #777; }
        .total-row span:last-child { font-size: 1.4rem; font-weight: 700; color: #e67e22; }
        .btn-confirm {
            width: 100%; padding: 0.85rem; background: #e67e22; color: #fff; border: none; border-radius: 8px;
            font-weight: bold; font-size: 1rem; cursor: pointer;
        }
        .btn-confirm:hover { background: #d35400; }
        .confirm-note { text-align: center; font-size: 0.8rem; color: #999; margin-top: 0.8rem; }
        .msg { background: #fde8e8; color: #b02a2a; padding: 0.7rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; text-align: center; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="hero-banner">
        <div class="hero-inner">
            <a href="index.php#packages" class="back-link">&larr; Back to Packages</a>
            <div class="hero-badges">
                <span class="hero-badge category"><?php echo htmlspecialchars($package['category']); ?></span>
                <?php if ($package['featured']): ?><span class="hero-badge featured">Featured</span><?php endif; ?>
            </div>
            <h1><?php echo htmlspecialchars($package['name']); ?></h1>
            <div class="hero-meta">
                <span>📍 <?php echo htmlspecialchars($package['location'] ?: 'Nepal'); ?></span>
                <span>⏱ <?php echo htmlspecialchars($package['duration']); ?></span>
                <span>👥 Max <?php echo htmlspecialchars($package['max_group']); ?> people</span>
            </div>
        </div>
    </div>

    <div class="detail-layout">
        <div class="detail-main">
            <h2>About This Tour</h2>
            <p class="about-text"><?php echo nl2br(htmlspecialchars($package['description'] ?: 'No description available yet.')); ?></p>

            <h2>Tour Highlights</h2>
            <div class="highlights-grid">
                <div class="highlight-box">
                    <span class="icon">📍</span>
                    <div><strong>Destination</strong><span><?php echo htmlspecialchars($package['location'] ?: 'Nepal'); ?></span></div>
                </div>
                <div class="highlight-box">
                    <span class="icon">⏱</span>
                    <div><strong>Duration</strong><span><?php echo htmlspecialchars($package['duration']); ?></span></div>
                </div>
                <div class="highlight-box">
                    <span class="icon">👥</span>
                    <div><strong>Group Size</strong><span>Up to <?php echo htmlspecialchars($package['max_group']); ?> people</span></div>
                </div>
                <div class="highlight-box">
                    <span class="icon">🏔</span>
                    <div><strong>Category</strong><span><?php echo htmlspecialchars($package['category']); ?></span></div>
                </div>
            </div>
        </div>

        <div class="booking-sidebar">
            <div class="price-header">$<?php echo number_format($package['price'], 0); ?> <span>/ person</span></div>
            <div class="booking-form-body">
                <?php if ($error): ?><p class="msg"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
                <form method="POST" action="booking.php?package=<?php echo $package['id']; ?>" id="bookingForm">
                    <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                    <div class="form-group">
                        <label>Number of People</label>
                        <div class="qty-stepper">
                            <button type="button" class="qty-btn" id="qtyMinus">-</button>
                            <span class="qty-value" id="qtyValue">1</span>
                            <button type="button" class="qty-btn" id="qtyPlus">+</button>
                            <input type="hidden" name="num_people" id="qtyInput" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Add Accommodation (optional)</label>
                        <select name="hotel_id" id="hotelSelect">
                            <option value="0">-- No hotel needed --</option>
                            <?php if ($hotels && $hotels->num_rows > 0): $hotels->data_seek(0); while ($h = $hotels->fetch_assoc()): ?>
                                <option value="<?php echo $h['id']; ?>" data-price="<?php echo $h['price_per_night']; ?>">
                                    <?php echo htmlspecialchars($h['name']) . " (" . htmlspecialchars($h['location']) . ") - $" . number_format($h['price_per_night'], 0) . "/night"; ?>
                                </option>
                            <?php endwhile; endif; ?>
                        </select>
                    </div>
                    <div class="form-group" id="nightsGroup" style="display:none;">
                        <label>Number of Nights</label>
                        <input type="number" name="nights" id="nightsInput" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="Your full name" value="<?php echo htmlspecialchars($prefill_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="your@email.com" value="<?php echo htmlspecialchars($prefill_email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+977-98XXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label>Travel Date</label>
                        <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="price-divider"></div>
                    <div class="total-row">
                        <span>Total Price</span>
                        <span id="totalPrice">$<?php echo number_format($package['price'], 0); ?></span>
                    </div>
                    <button type="submit" name="confirm_booking" class="btn-confirm">Confirm Booking</button>
                    <p class="confirm-note">You'll be asked to log in first if you're not signed in</p>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        const pricePerPerson = <?php echo (float) $package['price']; ?>;
        let qty = 1;
        const qtyValue = document.getElementById('qtyValue');
        const qtyInput = document.getElementById('qtyInput');
        const totalPrice = document.getElementById('totalPrice');
        const hotelSelect = document.getElementById('hotelSelect');
        const nightsGroup = document.getElementById('nightsGroup');
        const nightsInput = document.getElementById('nightsInput');

        function getHotelCost() {
            const selected = hotelSelect.options[hotelSelect.selectedIndex];
            const pricePerNight = parseFloat(selected.dataset.price) || 0;
            const nights = parseInt(nightsInput.value) || 0;
            return pricePerNight * nights;
        }

        function updateTotal() {
            qtyValue.textContent = qty;
            qtyInput.value = qty;
            const packageTotal = pricePerPerson * qty;
            const hotelTotal = getHotelCost();
            const grandTotal = packageTotal + hotelTotal;
            totalPrice.textContent = '$' + grandTotal.toLocaleString(undefined, { maximumFractionDigits: 0 });
        }

        document.getElementById('qtyMinus').addEventListener('click', function () {
            if (qty > 1) { qty--; updateTotal(); }
        });
        document.getElementById('qtyPlus').addEventListener('click', function () {
            qty++; updateTotal();
        });

        hotelSelect.addEventListener('change', function () {
            nightsGroup.style.display = (hotelSelect.value !== '0') ? 'block' : 'none';
            updateTotal();
        });
        nightsInput.addEventListener('input', updateTotal);
    </script>
</body>
</html>
