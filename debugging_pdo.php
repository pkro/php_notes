<?php

//require './db_conn.php';
$db = new PDO("sqlite:".__DIR__."/database.sqlite");

$year = 2008;
// Use named parameter in prepared statement
$sql = 'SELECT make, price FROM cars
        WHERE yearmade >= :yearmade';

//LEFT JOIN makes USING (make_id)
// Prepare statement and bind value to named parameter
$stmt = $db->prepare($sql);
$stmt->bindParam(':yearmade', $yearmade);
$stmt->execute();
// Display results
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['make'] . ': $' . $row['price'] . '<br>';
}
// Check for error message
$error = $stmt->errorInfo()[2];
if ($error) {
    echo $error;
}
echo '<br>';
echo '<pre>';

$stmt->debugDumpParams();

echo '</pre>';