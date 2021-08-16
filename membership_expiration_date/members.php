<?php
session_start();
// Redirect if not authenticated or logging out
if(!isset($_SESSION['authenticated']) || isset($_POST['logout'])) {
    if(isset($_POST['logout'])) {
        unset($_SESSION['authenticated']);
    }
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Members' Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Members Only</h1>
<p>Welcome!</p>
<form method="post" action="members.php">
    <p><input type="submit" name="logout" value="Log Out"></p>
</form>
</body>
</html>