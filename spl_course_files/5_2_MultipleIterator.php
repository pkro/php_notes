<?php

$boys = new ArrayIterator(['Ian', 'John', 'James']);
$girls = new ArrayIterator(['Jennifer', 'Alice', 'Susan']);
$unisex = new ArrayIterator(['Jody', 'Ales']);

$all = new MultipleIterator(MultipleIterator::MIT_NEED_ANY | MultipleIterator::MIT_KEYS_ASSOC);
$all->attachIterator($boys, "boys");
$all->attachIterator($girls, "girls");
$all->attachIterator($unisex, "any");

echo '<pre>';
foreach ($all as $names) {
    print_r($names);
}
echo '</pre>';

