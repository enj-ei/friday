<?php include 'includes/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trekking Packages</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/package.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <section class="packages-section">
        <h2>Featured Trekking Packages</h2>
        <div class="package-grid">

            <div class="package-card">
                <img src="https://picsum.photos/400/250?random=10" alt="Everest Base Camp">
                <div class="card-details">
                    <h3>Everest Base Camp Trek</h3>
                    <p class="meta">14 Days | Difficulty: Hard</p>
                    <span class="price">$1,450</span>
                    <a href="contact.php" class="btn-book">Book Now</a>
                </div>
            </div>

            <div class="package-card">
                <img src="https://picsum.photos/400/250?random=11" alt="Annapurna Circuit">
                <div class="card-details">
                    <h3>Annapurna Circuit</h3>
                    <p class="meta">12 Days | Difficulty: Moderate</p>
                    <span class="price">$1,100</span>
                    <a href="contact.php" class="btn-book">Book Now</a>
                </div>
            </div>

            <div class="package-card">
                <img src="https://picsum.photos/400/250?random=12" alt="Langtang Valley">
                <div class="card-details">
                    <h3>Langtang Valley Trek</h3>
                    <p class="meta">8 Days | Difficulty: Easy</p>
                    <span class="price">$850</span>
                    <a href="contact.php" class="btn-book">Book Now</a>
                </div>
            </div>

        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

</body>
</html>