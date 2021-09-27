<?php

$files = new RecursiveDirectoryIterator('./common', FilesystemIterator::UNIX_PATHS | FilesystemIterator::SKIP_DOTS);
$files = new RecursiveTreeIterator($files);
$files->setPrefixPart(RecursiveTreeIterator::PREFIX_LEFT, '&divideontimes;');
$files->setPrefixPart(RecursiveTreeIterator::PREFIX_MID_HAS_NEXT, '&Vdash;');
$files->setPrefixPart(RecursiveTreeIterator::PREFIX_END_HAS_NEXT, '&wr;');
$files->setPrefixPart(RecursiveTreeIterator::PREFIX_END_LAST, '&acd;');
foreach ($files as $file) {
    echo $file . '<br>';
}