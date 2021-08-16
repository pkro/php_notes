<?php
$text = new SplFileObject('paragraphs.txt');
$text = $text->fread($text->getSize());

$text = preg_replace("/[\r\n]+/", "</p><p>", trim($text));
$text = '<p>' . $text . '</p>';

//$text = nl2br($text);

echo $text;