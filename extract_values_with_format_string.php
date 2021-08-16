<?php

$colorString = 'rgb(23, 129, 162)'; // spaces are ignored
$var = sscanf($colorString, 'rgb(%3d,%3d,%3d)', $r, $g, $b);
// $a = 23, $b = 129, $c = 162
$hex = sprintf("#%2x%2x%2x", $r, $g, $b); // x automatically converts to hexadecimal
echo $hex; // #1781a2
