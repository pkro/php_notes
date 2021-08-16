<?php


$members = [
    ['first_name' => 'Tom', 'last_name' => 'Barker'],
    ['first_name' => 'David', 'last_name' => 'Phillips'],
    ['first_name' => 'Peter', 'last_name' => 'Johnson'],
    ['first_name' => 'Angela', 'last_name' => 'Phillips'],
    ['first_name' => 'Jodie', 'last_name' => 'Barker'],
    ['first_name' => 'Diana', 'last_name' => 'Johnson']
];

usort($members, function ($a, $b) {
    return $a['last_name'] <=> $b['last_name'];
});

// same as (PHP < 7):
/*usort($members, function ($a, $b) {
    if($a['last_name'] == $b['last_name']) {
        return 0;
    }
    return $a['last_name'] < $b['last_name'] ? -1 : 1;
});*/

// including first name as second priority:
usort($members, function ($a, $b) {
    return [$a['last_name'], $a['first_name']] <=> [$b['last_name'], $b['first_name']];
});

// the same works with php <7:
usort($members, function ($a, $b) {
    if([$a['last_name'], $a['first_name']] == [$b['last_name'], $b['first_name']]) {
        return 0;
    }
    return [$a['last_name'], $a['first_name']] < [$b['last_name'], $b['first_name']] ? -1 : 1;
});

foreach ($members as $member) {
    echo implode(' ', $member) . '<br>';
}

