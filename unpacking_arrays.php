<?php

$p = [
    ['a', '1.99'],
    ['b', '2.99'],
    ['c', '3.99']
];

[$p1, $p2, $p3] = $p;

print_r($p2); // ['b', '2.99']

foreach($p as list($item, $price)) {
    echo "{$item}: {$price}<br>";
}

/*
a: 1.99
b: 2.99
c: 3.99*/

// same as above
foreach($p as [$item, $price]) {
    echo "{$item}: {$price}<br>";
}

$p = [
    ['item'=>'a', 'price'=>'1.99'],
    ['item'=>'b', 'price'=>'2.99'],
    ['item'=>'c', 'price'=>'3.99']
];

foreach($p as ['item'=>$item, 'price'=>$price]) {
    echo "{$item}: {$price}<br>";
}