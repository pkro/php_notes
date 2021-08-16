<?php
if (isset($_POST['login'])) {
    // Fixed username and password for demo purposes only
    if ($_POST['username'] == 'David' && $_POST['password'] == 'secret') {
        // Create session and redirect to restricted page
        session_start();
        //$_SESSION['authenticated'] = true;
        $_SESSION['authenticated'] = time();

        $_SESSION['username'] = htmlentities($_POST['username']);
        session_regenerate_id();
        header('Location: restricted1.php');
        exit;
    } else {
        $error = '<p>Incorrect username or password</p>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Limit Session: Log in</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<h1>Log In</h1>
<?php
if (isset($error)) {
    echo $error;
}
?>
<form action="login.php" method="post">
    <p>
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
    </p>
    <p>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" value="Log in" name="login">
    </p>
</form>
</body>
</html>

