<?php

$files = new RecursiveDirectoryIterator(".", FilesystemIterator::UNIX_PATHS);
$files = new RecursiveIteratorIterator($files);
$files = new RegexIterator($files, "/.+?\.(?:png|jpg)/i");

foreach ($files as $file) { // $file is a SplFileInfo object
    echo $file->getFilename();
}
