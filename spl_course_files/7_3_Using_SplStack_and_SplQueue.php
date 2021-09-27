<?php

$stack = new SplStack();
$stack->add(0, 'A');
$stack[] = 'B';
$stack->push('C');
$stack[] = 'D';

show($stack); // DCBA

show($stack->pop()); //D

$q = new SplQueue();
$q->add(0, 'A');
$q->enqueue('B');
$q->push('C');
$q[] = 'D';

show($q); // ABCD
show($q->dequeue()); // A


function show($iter)
{
    if (is_iterable($iter)) {
        foreach ($iter as $val) {
            echo $val;
        }
    } else {
        echo $iter;
    }
    echo '<br></br>-----------------<br><br>';
}

