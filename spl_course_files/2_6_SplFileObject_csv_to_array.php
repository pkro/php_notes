<?php
echo '<pre>';
$csv = new SplFileObject('common/data/cars.csv');
$csv->setCsvControl(",", "\"");
$csv->setFlags(SplFileObject::READ_CSV);


$cars = [];
foreach ($csv as $line) {
    if (sizeof($line) > 1) {
        $cars[] = $line;
    }
}

var_dump($cars);
