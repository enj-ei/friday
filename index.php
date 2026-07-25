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

        .packages-search-bar {
            max-width: 1100px; margin: 0 auto 1.5rem; padding: 0 5%;
            display: flex; gap: 1rem; flex-wrap: wrap;
        }
        .packages-search-bar input[type="text"] {
            flex: 1; min-width: 240px; padding: 0.8rem 1rem; border: 1.5px solid #ddd;
            border-radius: 8px; font-size: 0.95rem;
        }
        .packages-search-bar select {
            padding: 0.8rem 1rem; border: 1.5px solid #ddd; border-radius: 8px; font-size: 0.95rem;
        }
        .filter-pills {
            max-width: 1100px; margin: 0 auto 0.8rem; padding: 0 5%;
            display: flex; gap: 0.6rem; flex-wrap: wrap;
        }
        .filter-pill {
            padding: 0.5rem 1.1rem; border-radius: 999px; border: 1.5px solid #ddd;
            background: #fff; color: #444; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s ease;
        }
        .filter-pill.active, .filter-pill:hover {
            background: #e67e22; border-color: #e67e22; color: #fff;
        }
        .results-count {
            max-width: 1100px; margin: 0 auto 1rem; padding: 0 5%;
            color: #777; font-size: 0.9rem;
        }
        .package-card { position: relative; }
        .package-card .img-wrap { position: relative; }
        .badge-category, .badge-price, .badge-featured {
            position: absolute; padding: 0.3rem 0.7rem; border-radius: 999px;
            font-size: 0.78rem; font-weight: 700;
        }
        .badge-category { top: 10px; left: 10px; background: rgba(255,255,255,0.9); color: #2c3e50; }
        .badge-price { top: 10px; right: 10px; background: rgba(255,255,255,0.95); color: #e67e22; }
        .badge-featured { bottom: 10px; left: 10px; background: #f1c40f; color: #4a3800; }
        .package-meta-row {
            display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.82rem; color: #777; margin: 0.6rem 0;
        }
        .package-meta-row span { display: flex; align-items: center; gap: 0.3rem; }
        .package-desc { color: #555; font-size: 0.88rem; line-height: 1.4; margin-bottom: 1rem; }

        .reviews-section { max-width: 1100px; margin: 3rem auto; padding: 0 5%; text-align: center; }
        .reviews-section h2 { color: #2c3e50; margin-bottom: 2rem; }
        .reviews-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .review-card { background: #fff; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.06); text-align: left; }
        .review-stars { color: #f39c12; font-size: 1.1rem; margin-bottom: 0.6rem; }
        .review-text { color: #444; font-style: italic; margin-bottom: 0.8rem; line-height: 1.4; }
        .review-author { color: #e67e22; font-weight: 600; font-size: 0.9rem; }

        .contact-hero {
            background: linear-gradient(135deg, #e67e22, #d35400);
            color: #fff; text-align: center; padding: 3.5rem 5%;
        }
        .contact-hero h2 { font-size: 2.2rem; margin-bottom: 0.6rem; }
        .contact-hero p { font-size: 1.05rem; opacity: 0.95; max-width: 600px; margin: 0 auto; }

        .contact-layout {
            max-width: 1100px; margin: 0 auto; padding: 3rem 5%;
            display: flex; gap: 2.5rem; flex-wrap: wrap; align-items: flex-start;
        }
        .contact-info-col { flex: 1; min-width: 280px; }
        .contact-info-col h3 { color: #2c3e50; margin-bottom: 0.6rem; font-size: 1.3rem; }
        .contact-info-sub { color: #777; font-size: 0.92rem; margin-bottom: 1.8rem; line-height: 1.5; }
        .contact-info-item { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .contact-icon {
            width: 42px; height: 42px; border-radius: 50%; background: #fdeadb;
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;
        }
        .contact-info-item strong { display: block; color: #2c3e50; font-size: 0.95rem; margin-bottom: 0.15rem; }
        .contact-info-item span { color: #777; font-size: 0.9rem; }

        .contact-form-col {
            flex: 1; min-width: 300px; background: #fff; padding: 2rem;
            border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        }
        .contact-form-col h3 { color: #2c3e50; margin-bottom: 1.2rem; font-size: 1.3rem; }
        .contact-form-col .form-group { margin-bottom: 1.2rem; }
        .contact-form-col label { display: block; margin-bottom: 0.4rem; color: #333; font-size: 0.9rem; font-weight: 500; }
        .contact-form-col input, .contact-form-col textarea {
            width: 100%; padding: 0.7rem 0.9rem; border: 1.5px solid #ddd; border-radius: 8px;
            font-size: 0.95rem; font-family: inherit;
        }
        .btn-send-new {
            width: 100%; padding: 0.85rem; background: #e67e22; color: #fff; border: none;
            border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer;
        }
        .btn-send-new:hover { background: #d35400; }
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

        <div class="packages-search-bar">
            <input type="text" id="pkgSearchInput" placeholder="Search packages, locations...">
        </div>

        <?php
        $categories = $conn->query("SELECT DISTINCT category FROM packages WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        ?>
        <div class="filter-pills" id="pkgFilterPills">
            <button class="filter-pill active" data-filter="All">All Packages</button>
            <?php if ($categories && $categories->num_rows > 0): while ($c = $categories->fetch_assoc()): ?>
                <button class="filter-pill" data-filter="<?php echo htmlspecialchars($c['category']); ?>"><?php echo htmlspecialchars($c['category']); ?></button>
            <?php endwhile; endif; ?>
        </div>

        <?php
        $home_packages = $conn->query("SELECT * FROM packages ORDER BY featured DESC, id ASC");
        $pkg_count = $home_packages ? $home_packages->num_rows : 0;
        ?>
        <p class="results-count" id="pkgResultsCount"><?php echo $pkg_count; ?> package<?php echo $pkg_count !== 1 ? 's' : ''; ?> found</p>

        <div class="package-grid" id="pkgGrid">
            <?php
            $random_seed = 10;
            if ($home_packages && $home_packages->num_rows > 0):
                while ($pkg = $home_packages->fetch_assoc()):
                    $random_seed++;
            ?>
            <div class="package-card"
                 data-category="<?php echo htmlspecialchars($pkg['category']); ?>"
                 data-search="<?php echo htmlspecialchars(strtolower($pkg['name'] . ' ' . $pkg['location'])); ?>">
                <div class="img-wrap">
                    <img src="https://picsum.photos/400/250?random=<?php echo $random_seed; ?>" alt="<?php echo htmlspecialchars($pkg['name']); ?>">
                    <span class="badge-category"><?php echo htmlspecialchars($pkg['category']); ?></span>
                    <span class="badge-price">$<?php echo number_format($pkg['price'], 0); ?>/person</span>
                    <?php if ($pkg['featured']): ?><span class="badge-featured">⭐ Featured</span><?php endif; ?>
                </div>
                <div class="card-details">
                    <div class="package-meta-row">
                        <span>📍 <?php echo htmlspecialchars($pkg['location'] ?: 'Nepal'); ?></span>
                        <span>⏱ <?php echo htmlspecialchars($pkg['duration']); ?></span>
                        <span>👥 Max <?php echo htmlspecialchars($pkg['max_group']); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($pkg['name']); ?></h3>
                    <p class="package-desc"><?php echo htmlspecialchars($pkg['description'] ?: 'Difficulty: ' . $pkg['difficulty']); ?></p>
                    <a href="booking.php?package=<?php echo $pkg['id']; ?>" class="btn-book">View &amp; Book</a>
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
    <section id="contact" class="contact-section-new">
        <div class="contact-hero">
            <h2>Get in Touch</h2>
            <p>Have questions about a tour package? We are here to help you plan your perfect trip.</p>
        </div>

        <div class="contact-layout">
            <div class="contact-info-col">
                <h3>Contact Information</h3>
                <p class="contact-info-sub">Reach us through any of these channels and we will get back to you as soon as possible.</p>

                <div class="contact-info-item">
                    <span class="contact-icon">📍</span>
                    <div><strong>Our Office</strong><span>Thamel, Kathmandu, Nepal 44600</span></div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-icon">✉️</span>
                    <div><strong>Email Us</strong><span>hello@tivetravels.com</span></div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-icon">📞</span>
                    <div><strong>Call Us</strong><span>+977 (01) 4-123456</span></div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-icon">🕒</span>
                    <div><strong>Working Hours</strong><span>Sun – Fri, 9:00 AM – 6:00 PM</span></div>
                </div>
            </div>

            <div class="contact-form-col">
                <h3>Send a Message</h3>

                <?php if ($contact_status):
                    list($status_type, $status_text) = explode(":", $contact_status, 2);
                ?>
                    <p style="padding:0.75rem; border-radius:6px; margin-bottom:1rem; font-weight:600;
                        background:<?php echo $status_type === 'success' ? '#d4edda' : '#fde8e8'; ?>;
                        color:<?php echo $status_type === 'success' ? '#155724' : '#b02a2a'; ?>;">
                        <?php echo htmlspecialchars($status_text); ?>
                    </p>
                <?php endif; ?>

                <form action="index.php#contact" method="POST">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Your full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="5" placeholder="Tell us about your travel plans or any questions you have..." required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="btn-send-new">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/slider.js"></script>
    <script src="js/nav-scroll.js"></script>
    <script src="js/package-filter.js"></script>
</body>
</html>
