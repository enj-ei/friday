<?php 
session_start();
include 'includes/connection.php'; 
$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role']; // 'user' or 'admin'

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                if (isset($_SESSION['pending_booking'])) {
                    $pb = $_SESSION['pending_booking'];
                    $insert = $conn->prepare("INSERT INTO bookings (user_id, package_name, booking_date, status) VALUES (?, ?, ?, 'pending')");
                    $insert->bind_param("iss", $user['id'], $pb['package_name'], $pb['booking_date']);
                    $insert->execute();
                    unset($_SESSION['pending_booking']);
                    header("Location: profile.php?booked=1");
                } else {
                    header("Location: index.php");
                }
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Tive Travels</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .auth-container { max-width: 400px; margin: 4rem auto; padding: 2rem; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px; }
        .auth-container h2 { margin-bottom: 1.5rem; text-align: center; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; }
        .form-group input { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { width: 100%; padding: 0.7rem; background: #e67e22; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .msg { color: red; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="auth-container">
        <h2>Login</h2>
        <?php if ($error): ?><p class="msg"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn-submit">Login</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
