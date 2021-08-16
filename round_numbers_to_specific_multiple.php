<?php
require "_util.php";

$width = 3264;
$height = 4928;
$new_height = 350;

$ratio = $new_height / $height;

// -1 rounds so a multiple of 10,
// -2 rounds so a multiple of 100 etc
//$new_width = round($width * $ratio, -2);

$new_width = roundNextMultiple($width * $ratio, 50);

ech($new_width);


function roundNextMultiple($val, $multiple)
{
    return ceil($val / $multiple) * $multiple;
}

function roundClosestMultiple($val, $multiple)
{
    return ceil($val / $multiple) * $multiple;
}