<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

// Add new package
if (isset($_POST['add_package'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $price = (float) $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO packages (name, duration, difficulty, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $duration, $difficulty, $price);
    if ($stmt->execute()) {
        $message = "Package added successfully!";
    } else {
        $message = "Error adding package.";
    }
    $stmt->close();
}

// Delete package
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: packages.php");
    exit();
}

$packages = $conn->query("SELECT * FROM packages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Packages - Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #34495e; color: #fff; }
        .form-card { background: #fff; padding: 1.5rem; border-radius: 6px; max-width: 500px; margin-top: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.5rem; }
        .btn-add { background: #e67e22; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 4px; cursor: pointer; }
        .btn-delete { color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2 style="color: #e67e22; margin-bottom: 2rem;">Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="bookings.php">Bookings</a></li>
                <li><a href="packages.php">Manage Packages</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Manage Trekking Packages</h1>
            <?php if ($message): ?><p style="color: green; margin: 1rem 0;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?>

            <table>
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Duration</th><th>Difficulty</th><th>Price</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php if ($packages && $packages->num_rows > 0): ?>
                        <?php while($p = $packages->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $p['id']; ?></td>
                                <td><?php echo htmlspecialchars($p['name']); ?></td>
                                <td><?php echo htmlspecialchars($p['duration']); ?></td>
                                <td><?php echo htmlspecialchars($p['difficulty']); ?></td>
                                <td>$<?php echo htmlspecialchars($p['price']); ?></td>
                                <td><a class="btn-delete" href="packages.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Delete this package?');">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No packages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="form-card">
                <h3>Add New Package</h3>
                <form method="POST" action="packages.php">
                    <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
                    <div class="form-group"><label>Duration (e.g. 14 Days)</label><input type="text" name="duration" required></div>
                    <div class="form-group">
                        <label>Difficulty</label>
                        <select name="difficulty" required>
                            <option value="Easy">Easy</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Price (USD)</label><input type="number" step="0.01" name="price" required></div>
                    <button type="submit" name="add_package" class="btn-add">Add Package</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>