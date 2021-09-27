<?php

$dir = new FilesystemIterator('./common/images', FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
// alternative: $dir->setFlags(FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
foreach ($dir as $key => $file) {
    if ($file->isFile()) { // only files, not directories
        echo $key . ": "; // relative path is the key
        echo $file . "<br>"; // ...and the value
        $files[] = $file; // works out of the box; $file is a SplFileInfo object
    }
}

echo $files[0]->getRealPath();