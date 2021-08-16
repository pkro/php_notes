<?php

$studentTable = new SplFileObject('../students.csv');

set_time_limit(5);
ini_set('auto_detect_line_endings', TRUE);
$csv = $data = '../students.csv';

function processCsv($csv)
{
    $csv = new SplFileObject($csv, 'r');
    $csv->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD);
    $headers = $csv->fgetcsv();

    while ($row = $csv->fgetcsv()) {
        yield array_combine($headers, $row);
    }
}

$rows = iterator_to_array(processCsv($data));

try {
    $db = new PDO('mysql:dbname=excel2db;host=localhost', 'root', 'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

} catch (PDOException $ex) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}


//$res = $db->query('select * from students');


$insertStateStmt = $db->prepare("INSERT INTO states (state) VALUES(:state)");
$insertProgramStmt = $db->prepare("INSERT INTO programs (program) VALUES(:program)");

$state2index = [];
$programs2index = [];
for ($i = 0; $i < count($rows); $i++) {
    $id[$i] = $rows[$i]['id'];
    $last[$i] = $rows[$i]['last'];
    $first[$i] = $rows[$i]['first'];
    $phone[$i] = $rows[$i]['phone'];
    $email[$i] = $rows[$i]['email'];
    $gradyear[$i] = $rows[$i]['gradyear'];
    $gpa[$i] = $rows[$i]['gpa'];

    $currentState = $rows[$i]['state'];

    if (!array_key_exists($currentState, $state2index)) {
        $insertStateStmt->bindValue(":state", $currentState);
        $success = $insertStateStmt->execute();
        $lastInsertId = $db->lastInsertId();
        $state2index[$currentState] = $lastInsertId;
        $state[$i] = $lastInsertId;
    } else {
        $state[$i] = $state2index[$currentState];
    }
}

echo '<pre>';
var_dump($state2index);
echo '</pre>';
exit;
/*
$db->beginTransaction();


foreach ($states as $idx => $state) {
    $stmt = $db->prepare($insertState);
    $stmt->bindValue(1, $idx, PDO::PARAM_INT);
    $stmt->bindValue(2, $state, PDO::PARAM_INT);
    $stmt->execute();
}



foreach ($programs as $idx => $program) {
    $stmt = $db->prepare($insertProgram);
    $stmt->bindValue(1, $idx, PDO::PARAM_INT);
    $stmt->bindValue(2, $state, PDO::PARAM_INT);
    $stmt->execute();
}

$insertProgram = "INSERT IGNORE INTO programs (program_id, program) VALUES(?, ?)";

foreach ($programs as $idx => $program) {
    $stmt = $db->prepare($insertProgram);
    $stmt->bindValue(1, $idx, PDO::PARAM_INT);
    $stmt->bindValue(2, $state, PDO::PARAM_INT);
    $stmt->execute();
}

$db->commit();*/