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
    $xml1 = new AuthorFilter($xml, 'Kevin Skoglund');
    $xml2 = new AuthorFilter($xml, 'David Gassner');
    $xml = new AppendIterator();
    $xml->append($xml1);
    $xml->append($xml2);

} catch (Exception $e) {
    echo $e->getMessage();
}

$previous = '';
foreach ($xml as $course) {
    //if ($course->author !== $previous) { // gotcha! $course->author is a simpleXML element!
    if ((string)$course->author !== $previous) {
        $prefix = sprintf("<h1>%s</h1><br>", $course->author);
    } else {
        $prefix = "";
    }
    $previous = (string)$course->author;
    echo $prefix . "{$course->title} (Level:  {$course->level})<br>";
}

