<?php

function add(...$nums) {
    $sum = 0;
    foreach($nums as $num) {
        $sum += $num;
    }
    return $sum;
}

echo add(1, 2, 3, 4);

function sum($a, $b, $c) {
    return $a + $b + $c;
}

$values = [1, 2, 3];

echo sum(...$values);

function test($vals) {
    print_r(func_get_args()); // ( [0] => 1 [1] => 2 [2] => 3 )
    echo func_num_args(); // 3
}

test(1,...[2,3]);

//Fatal error: Spread operator is not supported in assignments
// [$a, $b, ...$rest] = [1, 2, 3, 4, 5];