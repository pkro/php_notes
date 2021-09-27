<?php

$ar = [1, 2, 3];

$ar = new ArrayIterator($ar);
$ar = new NoRewindIterator($ar);

foreach ($ar as $value) {
    echo $value;
}
// doesn't print anything as iterator can't be reused
foreach ($ar as $value) {
    echo $value;
}

$e = new EmptyIterator();

// nada
foreach ($e as $value) {
    echo $value;
}