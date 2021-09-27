<?php
$files = new RecursiveDirectoryIterator("common");
$files->setFlags(FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS);

// without the RecursiveIteratorIterator, we just get the top level files / directories as usual

// shows only files (Top level / self not included)
//$files = new RecursiveIteratorIterator($files);
// shows files and directories (directories first)
$files = new RecursiveIteratorIterator($files, RecursiveIteratorIterator::SELF_FIRST);
$files->setMaxDepth(1);

foreach ($files as $file) {
    echo $file;
    echo "<br>";
}