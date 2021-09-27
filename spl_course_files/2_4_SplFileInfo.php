<?php
echo '<pre>';
$dir = new FilesystemIterator('./common/images', FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
// alternative: $dir->setFlags(FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
foreach ($dir as $key => $file) {
    if ($file->getExtension() == "jpg") {
        echo $file->getFileName() . " ({$file->getSize()} bytes)";
        echo "<br>";
        echo $file->getRealPath();
        echo "<br>";
        echo get_class($file);
        echo "<br>";

        echo "methods:\n";
        $ref = new ReflectionClass($file);
        foreach ($ref->getMethods() as $method) {
            echo substr($method,
                strpos($method, "method "),
                strpos($method, ' ]') - strpos($method, "method "));
            echo "\n";
        }
        echo "<br>";
        break;
    }
}

echo '</pre>';

/*
 * 70_rose_pink.jpg (1698 bytes)
/home/pk/projects/lynda/php_standard_library/common/images/70_rose_pink.jpg
SplFileInfo
methods:
method __construct
method getPath
method getFilename
method getExtension
method getBasename
method getPathname
method getPerms
method getInode
method getSize
method getOwner
method getGroup
method getATime
method getMTime
method getCTime
method getType
method isWritable
method isReadable
method isExecutable
method isFile
method isDir
method isLink
method getLinkTarget
method getRealPath
method getFileInfo
method getPathInfo
method openFile
method setFileClass
method setInfoClass
method __debugInfo
method _bad_state_ex
method __toString

 */