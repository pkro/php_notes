<?php

$days = [];
for ($i = 0; $i < 7; $i++) {
    $days[] = DateTime::createFromFormat("Ymd", 20210719 + $i)->format('l'); // just any monday
}

$days = new ArrayIterator($days);
$days = new InfiniteIterator($days);
$days = new LimitIterator($days, 2, 7); // wed to tuesday

foreach ($days as $day) {
    echo "$day<br>";
}
