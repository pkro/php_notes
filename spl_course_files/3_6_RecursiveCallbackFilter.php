<?php

try {
    $dir = new RecursiveDirectoryIterator('common', RecursiveDirectoryIterator::SKIP_DOTS);
    // ignore intellij complaining that callback must be a string, works with closure too
    $filtered = new RecursiveCallbackFilterIterator($dir, function ($current, $key, $iterator) {
        if ($iterator->hasChildren()) {
            return true;
        }
        return $current->getSize() > 1024 * 6;
    });
    $filtered = new RecursiveIteratorIterator($filtered);
} catch (Exception $exception) {
    echo $exception->getMessage();
}

foreach ($filtered as $file) {
    echo $file->getFilename() . ": " . $file->getSize() . "<br>";
}
