<?php

$now = new DateTime();
$expire = new DateTime('+ 3 months');
echo $expire->format('d.m.Y'); // 05.11.2021 (when done in august 5th 2021)
$formatForDB = $expire->format('Y-m-d H:i:s'); // 2021-11-05 08:47:47

$expire = new DateTime('last day of this month + 12 months');
echo $expire->format('Y-m-d'); // 2022-08-31 (when done on any day in august 2021)

$thanksgiving_ca = new DateTime('second Monday of October 2022');
echo $thanksgiving_ca->format('Y-m-d'); // 2022-10-10


