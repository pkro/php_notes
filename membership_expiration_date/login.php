<?php
session_start();
if(isset($_POST['login'])) {
    // Establish database connection
    require './db_conn.php';

    // Use a prepared statement to check credentials
    $sql = 'SELECT password, expiry FROM users WHERE username = :username';
    $stmt = $db->prepare($sql);

    // Bind values from user input to named placeholders
    $stmt->bindParam(':username', $_POST['username']);
//    $stmt->bindParam(':password', $_POST['password']);
    $stmt->execute();
    // Fetch the result
//    $pwd = $stmt->fetchColumn(0);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result && password_verify($_POST['password'], $result['password'])) {
        $expiry = new DateTime($result['expiry']);
        if (new DateTime() <= $expiry) {
            session_regenerate_id();
            $_SESSION['authenticated'] = true;
            header('Location: members.php');
            exit;
        } else {
            $message = 'Sorry, your subscription expired on ' . $expiry->format('F j, Y');
        }
    } else {
        $message = 'Sorry, incorrect username or password';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Log In</h1>
<?php
if(isset($message)) {
    echo "<p>$message</p>";
}
?>
<form method="post" action="login.php">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" name="login" value="login">
    </p>
</form>
</body>
</html>