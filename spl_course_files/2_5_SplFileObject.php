<?php
function brk()
{
    echo "<br>\n";
}

function b($str)
{
    echo "<b>{$str}</b>";
    brk();
}

echo '<pre>';
$dir = new FilesystemIterator('./common/documents', FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
// alternative: $dir->setFlags(FilesystemIterator::UNIX_PATHS | FilesystemIterator::KEY_AS_FILENAME);
foreach ($dir as $key => $file) {
    if ($file->getExtension() == "txt") {
        try {
            $fob = $file->openFile("r+");
        } catch (Exception $e) {
            echo "Couldn't open file in write mode";
            $fob = $file->openFile();
        }
        

        $fob->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);
        echo get_class($fob); // SolFileObject
        brk();
        b($fob->getFilename());

        foreach ($fob as $line) {
            echo $line;
            brk();
        }
        $fob->seek(2); // start from 3rd line
        echo $fob->current();
    }

    while (!$fob->eof()) {
        $fob->next();
    }
    if ($fob->isWritable()) {
        $fob->fwrite("\r\n\r\nYay adding stuff at the end");
    }
}

echo '</pre>';
