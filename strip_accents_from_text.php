<?php

// useful for e.g. allowing headlines of foreign languages to be used as url parts

$title = 'Steder å besøke i nærheten av Tromsø &amp; Kvaløya';


//$title = htmlentities($title);

// ignores already encoded entities such as &amp;
$title = htmlentities($title, ENT_COMPAT, 'utf-8', false);

echo '<pre>';
    //echo $title;
echo '</pre>';


function remove_accents($str, $charset='utf-8') {
    // Convert special characters to HTML character entities
    $str = htmlentities($str, ENT_COMPAT, $charset, false);
    // Keep the leading letter of accented characters
    $str = preg_replace('/&([a-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|tilde|uml);/i', '\1', $str);
    // Keep the leading two characters of ligatures
    $str = preg_replace('/&([a-z]{2})lig;/i', '\1', $str);
    // Remove all other HTML character entitites except &amp;
    $str = preg_replace('/&(?!amp)[a-z0-9]+;/i', '', $str);
    // Replace spaces with hyphens
    $str = str_replace(' ', '-', $str);
    return $str;
}

$title = '"Steder å besøke i nærheten av Tromsø &amp; Kvaløya"';
echo remove_accents($title);