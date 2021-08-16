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
<p>This is another restricted page.</p>
<p><a href="restricted1.php">Back to page 1</a>.</p>
<form method="post" action="includes/logout.php">
    <p>
        <input type="submit" name="logout" value="Log Out">
    </p>
</form>
</body>
</html>
