<?php
if(isset($_POST['register'])) {
    // Establish database connection
    require './db_conn.php';

    $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $expiry = (new DateTime('last day of this month + 12 months'))->format('Y-m-d');

    // Use prepared statement to register new user
    $sql = 'INSERT INTO users (username, password, expiry) 
            VALUES (:username, :password, :expiry)';
    $stmt = $db->prepare($sql);
    // Bind values from user input to named placeholders
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':password', $pwd);
    $stmt->bindParam(':expiry', $expiry);
    $stmt->execute();

    // If successful, rowCount() returns 1
    if($stmt->rowCount()) {
        $message = htmlentities($_POST['username']) . ' successfully registered. <a href="login.php">Log in</a>';
    } else {
        // Get database error message using array dereferencing
        // Replace this with a neutral error message in production
        $message = $stmt->errorInfo()[2];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Register</h1>
<?php
if(isset($message)) {
    echo "<p>$message</p>";
}
?>
<form method="post" action="register.php">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" name="register" value="Register">
    </p>
</form>
</body>
</html>