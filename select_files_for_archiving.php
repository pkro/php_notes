<?php

$files = new RecursiveDirectoryIterator('./', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS);
$files = new RecursiveIteratorIterator($files); // flatten

// remove "hidden" files
$files = new RegexIterator($files, '/\/\./', RegexIterator::MATCH, RegexIterator::INVERT_MATCH);

$now = new DateTime();
$files = new CallbackFilterIterator($files, function (SplFileInfo $file) use ($now) {
    $modified = new DateTime('@' . $file->getMTime());
    return $modified->diff($now)->days > 180;
});

/**
 * @var SplFileInfo $file
 */
foreach ($files as $filename => $file) {
    echo $filename .'=>'. $file->getPath() . '<br>';
}