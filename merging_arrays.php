<?php

$assoc1 = [
    'country' => 'USA',
    'population' => 325700000,
    'holiday' => '4 July'
];
$assoc2 = [
    'country' => 'UK',
    'GDP per capita' => '$39900'
];

// last array overwrites previous items with same keys
$merged = array_merge($assoc1, $assoc2);

// first array overwrites following
$added = $assoc1 + $assoc2;

echo '<pre>';
print_r($merged);
print_r($added);

$indexed1 = ['apples', 'oranges', 'grapes'];
$indexed2 = ['apples', 'pears', 'figs', 'grapes'];

$merged = array_merge($indexed1, $indexed2); // renumbers indexes and preserves all values
$added = $indexed1 + $indexed2; // drops values of duplicate indexes

print_r($merged);
print_r($added);

$num1 = [1, 2, 3];
$num2 = [1, 5, 6, 7, 8];

$merged = array_merge($num1, $num2); // just appends: 1,2,3,4,5,6
$added = $num1 + $num2; // 1,2,3,7,8

print_r($merged);
print_r($added);
echo '</pre>';