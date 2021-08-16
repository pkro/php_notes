<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    // Redirect if not logged in
    header('Location: https://localhost/php_notes/session_time_limit/login.php');
    exit;
}

$isExpired = true;
$sessionTimeout = 60*60; // 1 hour

if ($_SESSION['authenticated'] > 0 &&
    time() - $_SESSION['authenticated'] < 60 * 60) {
    $isExpired = false;
    require 'logout.php';
} else { // extend timeout
    $_SESSION['authenticated'] = time();
}

