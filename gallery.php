<?php
session_start();
include 'includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Photo Gallery - Trekking Adventure</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .gallery-container { max-width: 1200px; margin: 3rem auto; padding: 0 5%; text-align: center; }
        .gallery-container h1 { color: #2c3e50; margin-bottom: 2rem; }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; }
        .gallery-item { overflow: hidden; border-radius: 8px; }
        .gallery-item img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease; display: block; }
        .gallery-item img:hover { transform: scale(1.05); cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="gallery-container">
        <h1>Moments From Our Treks</h1>
        <div class="gallery-grid">
            <div class="gallery-item"><img src="IMG_6504.JPG" alt="Trek 1"></div>
            <div class="gallery-item"><img src="20260612143332423.jpg" alt="Trek 2"></div>
            <div class="gallery-item"><img src="IMG_9956.PNG" alt="Trek 3"></div>
            <div class="gallery-item"><img src="IMG_4682.JPG" alt="Trek 4"></div>
            <div class="gallery-item"><img src="IMG_0133.PNG" alt="Trek 5"></div>
            <div class="gallery-item"><img src="IMG_9956.PNG" alt="Trek 6"></div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>