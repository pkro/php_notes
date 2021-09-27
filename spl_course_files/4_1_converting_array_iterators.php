<?php

$languages = ['JS', 'C', 'PHP', 'Python'];

$languages = new ArrayIterator($languages); // convert to iterator
//$languages->asort(); // iterators implement many array functions as methods
$languages = new LimitIterator($languages, 0, 2);

// getArrayCopy from parent class returns the full array again and not the limited version, which we don't want
// phpstorm doesn't find method from parent
// $languages = $languages->getArrayCopy(); // ['JS', 'C', 'PHP', 'Python']

$languages = iterator_to_array($languages); // limited, ['JS', 'C']
$languages = array_reverse($languages);

foreach ($languages as $lang) {
    echo "{$lang}<br>";
}

