<?php
require "_util.php";
$info = getimagesize('files/hoover.jpg');

/* $info:
array(7) {
  [0]=>
  int(500)
  [1]=>
  int(332)
  [2]=>
  int(2)
  [3]=>
  string(24) "width="500" height="332""
  ["bits"]=>
  int(8)
  ["channels"]=>
  int(3)
  ["mime"]=>
  string(10) "image/jpeg"
}
 */


// Dereferencung directly from function (nothing special about this):
$bits = getimagesize('files/hoover.jpg')["bits"];

[$w, $h] = $info; // $w = 500, $h = 332

// using list:
list($w, $h) = $info;

// using non-numerical keys
[3 => $imgTagSizes, "mime" => $mimeType] = $info;
echo($imgTagSizes); // width="500" height="332"
echo($mimeType); // image/jpeg

// skipping elements:
[$w, , , $imgTagSizes] = $info;
