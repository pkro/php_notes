<?php
if (isset($_POST['logout']) || $isExpired) {
    session_start();
    // Set session to an empty array
    $_SESSION = [];
    // Set the browser cookie to expire 24 hours ago
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
    }
    // Destroy the session and redirect to login page
    session_destroy();
    header('Location: https://localhost/php_notes/session_time_limit/login.php');
    exit;
}