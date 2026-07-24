<?php include 'includes/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tive Travels - Home</title>

    <!-- All CSS File Links -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Slider -->
    <section class="slider-container">
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200');">
            <div class="slide-text">
                <h1>Discover New Heights</h1>
                <p>Unforgettable trekking experiences await you.</p>
            </div>
        </div>
        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1589182373726-e4f658ab50f0?w=1200');">
            <div class="slide-text">
                <h1>Explore the Wild</h1>
                <p>Guided adventure tours across stunning trails.</p>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/slider.js"></script>
</body>
</html>