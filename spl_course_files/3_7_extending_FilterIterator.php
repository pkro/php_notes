<?php

class AuthorFilter extends FilterIterator
{
    protected $author;

    public function __construct(Iterator $iterator, string $author)
    {
        $this->author = $author;
        parent::__construct($iterator);
    }

    public function accept()
    {
        if (property_exists($this->current(), 'author')) {
            return $this->current()->author == $this->author;
        } else {
            throw new Exception("element doesn't have an author field");
        }
    }
}


try {
    $xml = new SimpleXMLIterator('common/data/courses.xml', 0, true);
    $xml = new AuthorFilter($xml, 'Kevin Skoglund');
} catch (Exception $e) {
    echo $e->getMessage();
}

foreach ($xml as $course) {
    echo "{$course->title} with <b> {$course->author}</b> (Level:  {$course->level})<br>";
}

