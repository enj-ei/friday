<?php
session_start();
include '../includes/connection.php';
$error = "";

if (isset($_POST['admin_login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_name'] = $admin['name'];
            $_SESSION['role'] = 'admin';
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin account not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { background-color: #2c3e50; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 2rem; border-radius: 8px; width: 320px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .login-card h2 { margin-bottom: 1.5rem; text-align: center; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.3rem; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 0.7rem; background: #e67e22; border: none; color: #fff; font-weight: bold; border-radius: 4px; cursor: pointer; }
        .error { color: red; font-size: 0.85rem; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Admin Portal</h2>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label>Admin Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="admin_login" class="btn-login">Login to Dashboard</button>
        </form>
    </div>

</body>
</html>