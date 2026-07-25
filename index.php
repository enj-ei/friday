<?php
session_start();
include 'includes/connection.php';

$contact_status = "";

if (isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    if ($name === '' || $email === '' || $message === '') {
        $contact_status = "error:Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $contact_status = "success:Thanks! Your message has been received. We'll get back to you soon.";
        } else {
            $contact_status = "error:Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tive Travels - Home</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/package.css">
    <link rel="stylesheet" href="css/contact.css">

    <style>
        section { scroll-margin-top: 80px; }

        .about-section { max-width: 900px; margin: 3rem auto; padding: 0 5%; line-height: 1.6; color: #333; }
        .about-section h1 { color: #2c3e50; text-align: center; margin-bottom: 1.5rem; }
        .about-section p { margin-bottom: 1rem; font-size: 1.05rem; }
        .about-section .features { display: flex; gap: 1.5rem; margin-top: 2rem; }
        .about-section .feature-box { flex: 1; background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); text-align: center; }
        .about-section .feature-box h3 { color: #e67e22; margin-bottom: 0.5rem; }

        .destinations-container { max-width: 1200px; margin: 3rem auto; padding: 0 5%; }
        .destinations-container h1 { text-align: center; color: #2c3e50; margin-bottom: 2rem; }
        .destinations-container .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        .destinations-container .card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .destinations-container .card img { width: 100%; height: 220px; object-fit: cover; }
        .destinations-container .card-body { padding: 1.2rem; }
        .destinations-container .card-body h3 { color: #e67e22; margin-bottom: 0.5rem; }
        .destinations-container .card-body p { color: #555; font-size: 0.95rem; line-height: 1.4; }

        .gallery-container { max-width: 1200px; margin: 3rem auto; padding: 0 5%; text-align: center; }
        .gallery-container h1 { color: #2c3e50; margin-bottom: 2rem; }
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; }
        .gallery-item { overflow: hidden; border-radius: 8px; }
        .gallery-item img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease; display: block; }
        .gallery-item img:hover { transform: scale(1.05); cursor: pointer; }

        .reviews-section { max-width: 1100px; margin: 3rem auto; padding: 0 5%; text-align: center; }
        .reviews-section h2 { color: #2c3e50; margin-bottom: 2rem; }
        .reviews-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .review-card { background: #fff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); text-align: left; }
        .review-stars { color: #f39c12; font-size: 1.1rem; margin-bottom: 0.6rem; }
        .review-text { color: #444; font-style: italic; margin-bottom: 0.8rem; line-height: 1.4; }
        .review-author { color: #e67e22; font-weight: 600; font-size: 0.9rem; }
    </style>
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- HOME -->
    <section id="home" class="slider-container">
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

    <!-- ABOUT -->
    <section id="about" class="about-section">
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

    <!-- DESTINATIONS -->
    <section id="destinations">
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
                <div class="card">
                    <img src="https://picsum.photos/500/300?random=23" alt="Sailung Valley">
                    <div class="card-body">
                        <h3>Sailung Valley</h3>
                        <p>A quiet hill-station trek known for panoramic Himalayan views, rhododendron forests, and peaceful camping spots.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://picsum.photos/500/300?random=24" alt="Anjee Valley">
                    <div class="card-body">
                        <h3>Anjee Valley</h3>
                        <p>A hidden gem offering terraced farmlands, traditional villages, and scenic ridge-top trails away from the crowds.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="https://picsum.photos/500/300?random=25" alt="Yanzz Valley">
                    <div class="card-body">
                        <h3>Yanzz Valley</h3>
                        <p>A remote alpine valley popular with experienced trekkers for its dramatic passes and untouched natural beauty.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PACKAGES -->
    <section id="packages" class="packages-section">
        <h2>Featured Trekking Packages</h2>
        <div class="package-grid">
            <?php
            $home_packages = $conn->query("SELECT id, name, duration, difficulty, price FROM packages ORDER BY id ASC");
            $random_seed = 10;
            if ($home_packages && $home_packages->num_rows > 0):
                while ($pkg = $home_packages->fetch_assoc()):
                    $random_seed++;
            ?>
            <div class="package-card">
                <img src="https://picsum.photos/400/250?random=<?php echo $random_seed; ?>" alt="<?php echo htmlspecialchars($pkg['name']); ?>">
                <div class="card-details">
                    <h3><?php echo htmlspecialchars($pkg['name']); ?></h3>
                    <p class="meta"><?php echo htmlspecialchars($pkg['duration']); ?> | Difficulty: <?php echo htmlspecialchars($pkg['difficulty']); ?></p>
                    <span class="price">$<?php echo number_format($pkg['price'], 2); ?></span>
                    <a href="booking.php?package=<?php echo $pkg['id']; ?>" class="btn-book">Book Now</a>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p style="text-align:center; color:#666;">No packages available yet. Please check back soon.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery">
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
    </section>

    <!-- TESTIMONIALS -->
    <section id="reviews" class="reviews-section">
        <h2>What Our Trekkers Say</h2>
        <div class="reviews-grid">
            <?php
            $home_reviews = $conn->query("SELECT reviews.comment, reviews.rating, users.name FROM reviews JOIN users ON reviews.user_id = users.id ORDER BY reviews.created_at DESC LIMIT 6");
            if ($home_reviews && $home_reviews->num_rows > 0):
                while ($r = $home_reviews->fetch_assoc()):
            ?>
            <div class="review-card">
                <p class="review-stars"><?php echo str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']); ?></p>
                <p class="review-text">"<?php echo htmlspecialchars($r['comment']); ?>"</p>
                <p class="review-author">— <?php echo htmlspecialchars($r['name']); ?></p>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p style="text-align:center; color:#666;">No reviews yet. Be the first to share your experience!</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="contact-section">
        <h2>Get in Touch</h2>
        <p>Have questions about a trip or custom itinerary? Send us a message!</p>

        <?php if ($contact_status):
            list($status_type, $status_text) = explode(":", $contact_status, 2);
        ?>
            <p style="text-align:center; padding:0.75rem; border-radius:6px; margin-bottom:1rem; font-weight:600;
                background:<?php echo $status_type === 'success' ? '#d4edda' : '#fde8e8'; ?>;
                color:<?php echo $status_type === 'success' ? '#155724' : '#b02a2a'; ?>;">
                <?php echo htmlspecialchars($status_text); ?>
            </p>
        <?php endif; ?>

        <form class="contact-form" action="index.php#contact" method="POST">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="5" required></textarea>
            </div>
            <button type="submit" name="send_message" class="btn-send">Send Message</button>
        </form>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/slider.js"></script>
    <script src="js/nav-scroll.js"></script>
</body>
</html>
