<?php

function svg2uri(iterable $svgsSplFileInfo, int $w): iterable
{
    $uris = [];

    /** @var SplFileInfo $svg */
    foreach ($svgsSplFileInfo as $svg) {
        $current = $svg->openFile();
        $content = $current->fread($current->getSize());
        $inlineSvg = rawurlencode($content);
        // restore permitted characters
        $inlineSvg = str_replace(['%09', '%20', '%3D', '%3A', '%2F', '%22', '%0A', '%0D'],
            [' ', ' ', '=', ':', '/', "'"],
            $inlineSvg);
        $uris[] = sprintf('<img width=%s src="data:image/svg+xml;utf8,%s">', $w, $inlineSvg);
    }

    return $uris;
}

$svgs = new RegexIterator(new DirectoryIterator('./files/'), "/.+?\.svg/i");

$tags = svg2uri($svgs, 100);

foreach ($tags as $tag) {
    echo $tag;
}

$s1 = "hello";
$s2 = "there";

[$news1, $news2] = str_replace("e", "3", [$s1, $s2,]);

echo $news1;
echo $news2;

echo str_replace([' ', ',', '.', ';', '!', '?'], "_", "this sentence; is NOT! a good filename.");
// this_sentence__is_NOT__a_good_filename_