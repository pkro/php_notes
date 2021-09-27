<?php

$dll = new SplDoublyLinkedList();
$dll->add(0, 1); // index can be specified, though it's meant to be used sequentially
$dll->push(2);
$dll->push(3);

echo $dll->bottom(); // 1
echo $dll->top(); // 3

$stack = new SplStack();
$stack->push(1);
$stack->push(2);
$stack->push(3);

echo $stack->pop(); // 3

$q = new SplQueue();

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);

echo $q->dequeue(); // 1

$heap = new SplMinHeap();
