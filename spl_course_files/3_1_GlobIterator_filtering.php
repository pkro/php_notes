<?php

// in windows, GlobIterator needs the full path
$files = new GlobIterator(__DIR__ . '/common/images/*.jpg');

foreach ($files as $file) { // $file is a SplFileInfo object
    echo $file->getFilename();
}
