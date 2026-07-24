<?php include 'includes/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Tive travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>

    <section class="contact-section">
        <h2>Get in Touch</h2>
        <p>Have questions about a trip or custom itinerary? Send us a message!</p>

        <form class="contact-form" action="" method="POST">
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

</body>
</html>