<?php

class FilterByExtension extends RecursiveFilterIterator
{
    protected $extensions = [];

    public function __construct(RecursiveIterator $iterator, $extensions)
    {
        parent::__construct($iterator);
        if (!is_array($extensions)) { // for just one extension passed as string
            $extensions = (array)$extensions; // same as $extensions = [$extensions];
        }
        $this->extensions = $extensions;
    }

    // must be implemented for recursive iterator IF the constructor is not the default constructor like here
    public function getChildren()
    {
        // returns new FilterByExtension iterator with its children
        return new self($this->getInnerIterator()->getChildren(), $this->extensions);
    }


    function accept()
    {
        if ($this->hasChildren()) { // NOT this->current()->hasChildren
            return true;
        }
        return in_array($this->current()->getExtension(), $this->extensions);
    }
}


try {
    $files = new RecursiveDirectoryIterator('common', RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::UNIX_PATHS);
    $files = new FilterByExtension($files, ['png', 'gif']);
    $files = new RecursiveIteratorIterator($files);
} catch (Exception $exception) {
    echo $exception->getMessage();
}

foreach ($files as $file) {
    echo $file->getFilename() . ": " . $file->getSize() . "<br>";
}
