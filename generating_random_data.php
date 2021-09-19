<?php
echo '<pre>';

echo bin2hex(random_bytes(16));

$cards = [];

foreach(array_merge(range(2,10), ['ace', 'jack', 'queen', 'king']) as $val) {
    foreach (['spades', 'diams', 'hearts', 'cross'] as $color) {
        $cards[] = "$val of $color";
    }
}


var_dump($cards);

for ($i = 0; $i < count($cards); $i++) {
    $switchWith = random_int(0, count($cards)-1);
    [$cards[$i], $cards[$switchWith]] = [$cards[$switchWith], $cards[$i]];
}

var_dump($cards);

echo '</pre>';