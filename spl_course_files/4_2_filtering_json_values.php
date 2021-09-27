<?php
$courses = file_get_contents("./common/data/courses.json");

try {
    $courses = json_decode($courses, false, 512, JSON_THROW_ON_ERROR);
} catch (Exception $exception) {
    echo $exception->getMessage();
}

class FieldFilter extends FilterIterator
{
    private string $field;
    private string $content;

    public function __construct(Iterator $iterator, string $field, string $content)
    {
        parent::__construct($iterator);
        $this->field = $field;
        $this->content = $content;
    }

    public function accept()
    {
        $field = $this->field;
        return $this->current()->$field === $this->content;
    }
}

$courses = new ArrayIterator($courses);
$courses = new FieldFilter($courses, 'author', 'David Powers');
$courses = iterator_to_array($courses);

echo '<pre>';
var_export($courses);
echo '</pre>';
