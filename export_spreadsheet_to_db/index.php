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



try {
    $db = new PDO('mysql:dbname=excel2db;host=localhost', 'root', 'root',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

} catch (PDOException $ex) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}


//$res = $db->query('select * from students');


$insertStateStmt = $db->prepare("INSERT INTO states (state) VALUES(:state)");
$insertProgramStmt = $db->prepare("INSERT INTO programs (program) VALUES(:program)");
$insertStudentStmt = $db->prepare("INSERT INTO students (student_id, last_name, first_name, state_id, email, gradyear, program_id) values (:student_id, :last_name, :first_name, :state_id, :email, :gradyear, :program_id)");

$state2index = [];
$program2index = [];
$bindAr = [];

$db->beginTransaction();

foreach(processCsv($data) as $row) {
    $bindAr[':student_id'] = $row['id'];
    $bindAr[':last_name'] = $row['last'];
    $bindAr[':first_name'] = $row['first'];
    $bindAr[':email'] = $row['email'];
    $bindAr[':gradyear'] = $row['gradyear'];

    $currentState = $row['state'];

    if (!array_key_exists($currentState, $state2index)) {
        $insertStateStmt->bindValue(":state", $currentState);
        $success = $insertStateStmt->execute();
        $lastInsertId = $db->lastInsertId();
        $state2index[$currentState] = $lastInsertId;
        $bindAr[':state_id'] = $lastInsertId;
    } else {
        $bindAr[':state_id'] = $state2index[$currentState];
    }

    $currentProgram = $row['program'];

    if (!array_key_exists($currentProgram, $program2index)) {
        $insertProgramStmt->bindValue(":program", $currentProgram);
        $success = $insertProgramStmt->execute();
        $lastInsertId = $db->lastInsertId();
        $program2index[$currentProgram] = $lastInsertId;
        $bindAr[':program_id'] = $lastInsertId;
    } else {
        $bindAr[':program_id'] = $program2index[$currentProgram];
    }

    $insertStudentStmt->execute($bindAr);
    $insertStudentStmt->debugDumpParams();
}

$db->commit();
