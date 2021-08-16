<?php

$text = new SplFileObject('alice.txt');
$text = $text->fread($text->getSize());

function getSentences($text, $numSentences=-1)
{

    $pattern = '/([.!?]["\']?\)?\s)/';
//$pattern = '/[.!?].?/';
    $sentences = preg_split($pattern, $text, $numSentences, PREG_SPLIT_DELIM_CAPTURE);

    for ($i = 0; $i < count($sentences)-1; $i+=2) {
        $sentences[$i] = $sentences[$i] . $sentences[$i + 1];
        unset($sentences[$i + 1]);
    }

    return $sentences;
}
print_r(getSentences($text, 4));

