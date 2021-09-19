<?php
echo '<pre>';

function addTax($net, $rate)
{
    return number_format($net + $net * $rate / 100, 2);
}

$prices = [9.95, 20.49, 6.75];

// Using foreach and passing by reference:
foreach ($prices as &$price) {
    $price = addTax($price, 10);
}
var_dump($prices);

$prices = [9.95, 20.49, 6.75];

$prices = array_map('addTax', $prices, [20]);

var_dump($prices);



echo '</pre>';
