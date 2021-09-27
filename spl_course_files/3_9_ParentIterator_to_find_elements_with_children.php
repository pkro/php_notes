<?php
try {
    $dirs = new RecursiveDirectoryIterator('.');
    $dirs = new ParentIterator($dirs);
    // by default, RecursiveIteratorIterator applies to LEAVES_ONLY, so it never returns a node with children
    $dirs = new RecursiveIteratorIterator($dirs, RecursiveIteratorIterator::SELF_FIRST);

} catch (Exception $exception) {
    echo $exception->getMessage();
}

foreach ($dirs as $dir) {
    echo "{$dir->getFilename()}<br>";
}
