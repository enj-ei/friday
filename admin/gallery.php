<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

// Delete Handler
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        $file_path = "../" . $row['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $del = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $del->bind_param("i", $delete_id);
        $del->execute();
        $message = "Photo deleted successfully.";
    }
}

// Image Upload Handler
if (isset($_POST['upload_image']))  {
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $target_dir = "../images/";

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        switch ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = "That file is too large. Maximum allowed size is 2MB.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Please choose a photo to upload.";
                break;
            default:
                $message = "Upload failed. Please try again.";
        }
    } else {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $original_name = basename($_FILES["image"]["name"]);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        $img_info = getimagesize($_FILES["image"]["tmp_name"]);

        if (!in_array($ext, $allowed_ext) || $img_info === false) {
            $message = "Only JPG, PNG, or WEBP image files are allowed.";
        } else {
        // Generate a unique, safe filename instead of trusting the uploaded name
        $file_name = uniqid('gallery_', true) . '.' . $ext;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO gallery (image_path, caption) VALUES (?, ?)");
            $image_path = "images/$file_name";
            $stmt->bind_param("ss", $image_path, $caption);
            if ($stmt->execute()) {
                $message = "Photo uploaded successfully!";
            } else {
                $message = "Database error while saving photo.";
            }
        } else {
            $message = "Failed to upload photo.";
        }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Gallery - Admin</title>
    <style>
        * { margin:0; padding:0; box-sizing: border-box; font-family: sans-serif; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 1.5rem; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { margin-bottom: 1rem; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; }
        .main-content { flex: 1; background: #f4f6f7; padding: 2rem; }
        .upload-card { background: #fff; padding: 1.5rem; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 500px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; }
        .form-group input { width: 100%; padding: 0.5rem; }
        .btn-upload { background: #e67e22; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .gallery-manage-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.2rem; max-width: 900px;
        }
        .gallery-manage-item {
            background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .gallery-manage-item img { width: 100%; height: 130px; object-fit: cover; display: block; }
        .gallery-caption { padding: 0.6rem 0.7rem 0.2rem; font-size: 0.85rem; color: #333; }
        .btn-delete-photo {
            display: block; text-align: center; color: #c0392b; text-decoration: none; font-size: 0.82rem;
            font-weight: 600; padding: 0.5rem; border-top: 1px solid #f0f0f0;
        }
        .btn-delete-photo:hover { background: #fde8e8; }
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
            <h1>Manage Gallery Images</h1>
            <br>
            <?php if ($message): ?><p style="color: green; margin-bottom: 1rem;"><?php echo $message; ?></p><?php endif; ?>

            <div class="upload-card">
                <h3>Upload New Gallery Image</h3>
                <form method="POST" action="gallery.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Caption</label>
                        <input type="text" name="caption" required>
                    </div>
                    <div class="form-group">
                        <label>Select Photo</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" name="upload_image" class="btn-upload">Upload Photo</button>
                </form>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Existing Photos</h3>
            <div class="gallery-manage-grid">
                <?php
                $gallery_photos = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
                if ($gallery_photos && $gallery_photos->num_rows > 0):
                    while ($g = $gallery_photos->fetch_assoc()):
                ?>
                    <div class="gallery-manage-item">
                        <img src="../<?php echo htmlspecialchars($g['image_path']); ?>" alt="<?php echo htmlspecialchars($g['caption']); ?>">
                        <p class="gallery-caption"><?php echo htmlspecialchars($g['caption']); ?></p>
                        <a href="gallery.php?delete=<?php echo $g['id']; ?>" class="btn-delete-photo" onclick="return confirm('Delete this photo permanently?');">Delete</a>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <p style="color:#666;">No photos uploaded yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

</body>
</html>