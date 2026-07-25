<?php 
include 'includes/connection.php'; 
$message = "";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $message = "Email is already registered!";
    } else {
        $insert = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
        $insert->bind_param("sss", $name, $email, $password);
        if ($insert->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $message = "Error registering user.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Tive Travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .auth-container { max-width: 400px; margin: 4rem auto; padding: 2rem; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px; }
        .auth-container h2 { margin-bottom: 1.5rem; text-align: center; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; }
        .form-group input { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { width: 100%; padding: 0.7rem; background: #e67e22; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background: #d35400; }
        .msg { color: red; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="auth-container">
        <h2>Create Account</h2>
        <?php if ($message): ?><p class="msg"><?php echo $message; ?></p><?php endif; ?>
        <form id="registerForm" method="POST" action="register.php">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit" name="register" class="btn-submit">Register</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/validation.js"></script>
</body>
</html>