<?php
require 'includes/check_login.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restricted Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Restricted Page</h1>
<p>You are logged in as <?= $_SESSION['username']; ?>.</p>
<p><a href="restricted2.php">Go to another restricted page</a>.</p>
<form method="post" action="includes/logout.php">
    <p>
        <input type="submit" name="logout" value="Log Out">
    </p>
</form>
</body>
</html>
