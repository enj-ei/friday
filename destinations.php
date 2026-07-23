<?php include 'includes/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Destinations - Trekking Adventure</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .destinations-container { max-width: 1200px; margin: 3rem auto; padding: 0 5%; }
        .destinations-container h1 { text-align: center; color: #2c3e50; margin-bottom: 2rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 220px; object-fit: cover; }
        .card-body { padding: 1.2rem; }
        .card-body h3 { color: #e67e22; margin-bottom: 0.5rem; }
        .card-body p { color: #555; font-size: 0.95rem; line-height: 1.4; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="destinations-container">
        <h1>Popular Destinations</h1>
        <div class="grid">
            <div class="card">
                <img src="https://picsum.photos/500/300?random=20" alt="Everest Region">
                <div class="card-body">
                    <h3>Everest Region</h3>
                    <p>Home to the world's highest peak. Experience iconic Sherpa culture, high mountain passes, and stunning glacier views.</p>
                </div>
            </div>
            <div class="card">
                <img src="https://picsum.photos/500/300?random=21" alt="Annapurna Region">
                <div class="card-body">
                    <h3>Annapurna Region</h3>
                    <p>Famous for diverse landscapes ranging from subtropical forests to arid high-altitude deserts and mountain vistas.</p>
                </div>
            </div>
            <div class="card">
                <img src="https://picsum.photos/500/300?random=22" alt="Langtang Valley">
                <div class="card-body">
                    <h3>Langtang Valley</h3>
                    <p>Closest trekking region from the capital, offering beautiful valley trails, Tamang heritage, and serene landscapes.</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>