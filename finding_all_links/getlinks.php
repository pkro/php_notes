<?php

// PHP uses xml internally and html is mostly not strictly xml compliant
libxml_use_internal_errors(true);

$doc = new DOMDocument();
if( ! $doc->loadHTMLFile('attractions.html')) {
    // or
    // $doc->loadHTMLFile('http://localhost' . dirname($_SERVER['PHP_SELF']) . '/attractions.html');
    echo "couldn't load file";
} else {
    $links = $doc->getElementsByTagName('a');
    /**
     * @ @var $link DOMElement
     */
    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $linkText = $link->textContent;
        echo "{$href} text: $linkText<br>";
    }
}



