<?php
// Define error page
$error = 'http://localhost/php_notes/file_download/error.php';
// File path to downloads folder
$filepath = __DIR__ . DIRECTORY_SEPARATOR . 'downloads';

$filename = null;

if(isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
    $filename = $_GET['file'];
} else {
    header("Location: $error");
    exit;
}


if (!is_null($filename)) {
    $abs_path = $filepath . DIRECTORY_SEPARATOR . $filename;

    if (file_exists($abs_path) && is_readable($abs_path)) {
        header('Content-Type: application/octet-stream');
        header('Content-length: ' . filesize($abs_path));
        header('Content-disposition: attachment; filename=' . $filename);
        header('Content-transfer-encoding: binary');
        readfile($abs_path);
    } else {
        header("Location: $error");
        exit;
    }
}