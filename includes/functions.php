<?php
// Helper functions for security, sanitization, and session checks

function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}
?>