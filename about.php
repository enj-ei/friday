<?php
session_start();
include 'includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Tive Travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .about-section { max-width: 900px; margin: 3rem auto; padding: 0 5%; line-height: 1.6; color: #333; }
        .about-section h1 { color: #2c3e50; text-align: center; margin-bottom: 1.5rem; }
        .about-section p { margin-bottom: 1rem; font-size: 1.05rem; }
        .features { display: flex; gap: 1.5rem; margin-top: 2rem; }
        .feature-box { flex: 1; background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); text-align: center; }
        .feature-box h3 { color: #e67e22; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <section class="about-section">
        <h1>About Tive travels</h1>
        <p>Welcome to Tive travels! We specialize in providing unforgettable high-altitude trekking experiences, adventure tours, and eco-friendly mountain expeditions.</p>
        <p>Our team of experienced guides ensures that your trip is safe, memorable, and customized to your skill level. Whether you are seeking a challenging trail or a peaceful scenic walk, we have something for every traveler.</p>

        <div class="features">
            <div class="feature-box">
                <h3>Expert Guides</h3>
                <p>Local, certified guides with decades of trail experience.</p>
            </div>
            <div class="feature-box">
                <h3>Safety First</h3>
                <p>Complete safety protocols, gear, and medical emergency preparedness.</p>
            </div>
            <div class="feature-box">
                <h3>Eco Treks</h3>
                <p>Committed to eco-friendly and sustainable mountain tourism.</p>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>