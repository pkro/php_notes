<?php
set_time_limit(5);
ini_set('auto_detect_line_endings',TRUE);
$csv = $data = '../students.csv';

function processCsv($csv)
{
    $csv = new SplFileObject($csv, 'r');
    $csv->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE | SplFileObject::READ_AHEAD);
    $headers = $csv->fgetcsv();

    // this loops eternally because $row is null at the EOF
    // while (($row = $csv->fgetcsv()) !== FALSE) {
    // this works as null is treated like false
    // this makes no sense, as the various flags to ignore empty lines are set
    while ($row = $csv->fgetcsv()) {
        yield array_combine($headers, $row);
    }
}
echo '<pre>';
foreach (processCsv($data) as $item) {
    continue;
}
echo "done";
echo '</pre>';
