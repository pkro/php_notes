<?php
$products = array(
    'Cameras' => array('DSLR', 'smartphone', 'compact'),
    'Lenses' => array('telephoto', 'wide angle', 'fisheye'),
    'Accessories' => array('tripod', 'camera bag', 'Filters' =>
        array('polarizing', 'UV', 'neutral density')));

$iter = new RecursiveArrayIterator($products);
$iter = new RecursiveIteratorIterator($iter, RecursiveIteratorIterator::SELF_FIRST);


foreach ($iter as $category => $item) {
    // $prefix = str_repeat('-', $iter->getDepth()); // no "-" for depth 0
    // echo $prefix;
    $level = $iter->getDepth() + 1;

    if ($iter->hasChildren()) {
        echo "<H{$level}>";
        echo "{$category}<br>";
        echo "</H{$level}>";
    } else {
        echo "{$item}<br>";
    }
}