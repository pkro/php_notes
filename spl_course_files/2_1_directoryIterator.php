<?php

$dir = new DirectoryIterator('./common/images');

foreach ($dir as $key => $file) {
    if ($file->isFile()) { // only files, not directories
        echo $key . ": "; // 0,1,2... (skipping the directories)
        echo $file->getRealPath() . "<br>";
        // this doesn't work (you would expect $files to be an array of file objects,
        $wrongFileArray[] = $file;
        // this does
        $files[] = clone $file; //
    }
}

echo $wrongFileArray[0]->getRealPath(); // prints nothing
echo $files[0]->getRealPath(); // prints path as expected