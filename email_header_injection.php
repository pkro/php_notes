<?php
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    //$email = $_POST['email'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $comments = $_POST['comments'];

    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Comments: $comments";

    // last argument allows addtitional headers to be added maliciously! Same way as SQL injection
    // solution: filter_input above.
    // Also, From: shouldn't be used as it's not really coming from the server hosting that address.
    // better:
    $headers = "From: webmaster@example.com\r\nReply-to: $email";
    mail('me@example.com', 'Form feedback', $message, $headers);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Header Injection</title>
</head>
<body>
<h1>Email Header Injection</h1>
<form action="form.php" method="post">
    <p>
        <label for="name">Name: </label>
        <input type="text" name="name" id="name">
    </p>
    <p>
        <label for="email">Email address: </label>
        <input type="email" name="email" id="email">
    </p>
    <p>
        <label for="comments">Comments: </label>
        <textarea name="comments" id="comments"></textarea>
    </p>
    <p>
        <input type="submit" name="send" value="Submit">
    </p>
</form>
</body>
</html>