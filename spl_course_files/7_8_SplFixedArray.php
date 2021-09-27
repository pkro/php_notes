<?php

$animals = ['horse', 'cow', 'aardvark', 'dog', 'zebra', 'monkey', 'dog', 'cat'];

$animalsFixedArray = SplFixedArray::fromArray($animals);

$otherAr = new SplFixedArray(count($animals));
$runner = 0;
foreach ($animals as $animal) {
    // $otherAr[] = $animal; // doesn't work
    $otherAr[$runner++] = $animal;
}
print_r($otherAr);

// SplFixedArray Object ( [0] => horse [1] => cow [2] => aardvark [3] => dog [4] => zebra [5] => monkey [6] => dog [7] => cat )

//$otherAr[$runner] = 'out of range error';

// adjust size on the fly
$otherAr->setSize($otherAr->getSize() + 1);
$otherAr[$runner] = 'but now it works';