<?php
// Database connection (not included in exercise files)
require './db_conn.php';

$data = './students.csv';

// Generator to access CSV file as an associative array one line at a time
function processCsv($file) {
    $csv = fopen($file, 'r');
    // Get first row of column headers
    $headers = fgetcsv($csv);
    while (($row = fgetcsv($csv)) !== false) {
        // Use headers as array keys
        yield array_combine($headers, $row);
    }
    fclose($csv);
}

// Initialize prepared statements to insert values into database
$stmt1 = $db->prepare('INSERT INTO states (state) VALUES (:state)');
$stmt2 = $db->prepare('INSERT INTO programs (program) VALUES (:program)');
$stmt3 = $db->prepare('INSERT INTO students (student_id, last_name, first_name, state_id, email, gradyear, program_id)
                      VALUES (:id, :last, :first, :state, :email, :year, :prog)');

// Initialize arrays and counters
$states = [];
$programs = [];
$st = 0;
$pr = 0;

/**
 * PKR: I think this is just a lucky guess that the DBs insert ID is just incrementing
 */


// Process each line of the CSV file
foreach (processCsv($data) as $row) {
    // If state hasn't been registered, insert into database
    if (!in_array($row['state'], $states)) {
        $states[++$st] = $row['state'];
        $stmt1->execute([':state' => $row['state']]);
        // Use the counter as the state's primary key
        $state_id = $st;
    } else {
        // If state is already registered, get its index (primary key)
        $state_id = array_search($row['state'], $states);
    }
    // If program hasn't been registered, insert into database
    if (!in_array($row['program'], $programs)) {
        $programs[++$pr] = $row['program'];
        $stmt2->execute([':program' => $row['program']]);
        // Use the counter as the program's primary key
        $program_id = $pr;
    } else {
        // If program is already registered, get its index (primary key)
        $program_id = array_search($row['program'], $programs);
    }
    // Insert current row into database, using foreign keys for state & program
    $stmt3->execute([
        ':id'    => $row['id'],
        ':last'  => $row['last'],
        ':first' => $row['first'],
        ':state' => $state_id,
        ':email' => $row['email'],
        ':year'  => $row['gradyear'],
        ':prog'  => $program_id
    ]);
}
echo 'Done';