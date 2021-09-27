<?php

$animals = ['horse', 'cow', 'aardvark', 'dog', 'zebra', 'monkey', 'dog', 'cat'];

$min = new SplMinHeap();
foreach ($animals as $animal) {
    $min->insert($animal);
}

show($min->top()); // aardvark (root node with "highest" value)
show($min->top()); // still aardvark (nothing was removed)
show($min->current()); // still aardvark (alias for top())
$min->next();
show($min->top()); // cat!

$min = new SplMinHeap();
foreach ($animals as $animal) {
    $min->insert($animal);
}

echo '<pre>';
print_r($min);
/*SplMinHeap Object
(
    [flags:SplHeap:private] => 0
    [isCorrupted:SplHeap:private] =>
    [heap:SplHeap:private] => Array
(
    // internally stored as array
    [0] => aardvark // only root object is in its place, the rest gets calculated on the go
    [1] => cat
    [2] => cow
    [3] => dog
    [4] => zebra
    [5] => monkey
    [6] => dog
    [7] => horse
)

)*/
echo '</pre>';

show($min); // aardvark cat cow dog dog horse monkey zebra
show($min); // nothing - tree is empty because it was accessed!

$max = new SplMaxHeap();
foreach ($animals as $animal) {
    $max->insert($animal);
}

show($max->top()); // Zebra

function show($iter)
{
    if (is_iterable($iter)) {
        foreach ($iter as $val) {
            echo $val . ' ';
        }
    } else {
        echo $iter;
    }
    echo '<br>-----------------<br>';
}

