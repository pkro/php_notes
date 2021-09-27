<?php

class SortCourses extends SplHeap
{
    protected function compare($value1, $value2)
    {
        // cast to string when using SimpleXML objects!
        // Not necessary (but doesn't hurt) for JSON
        $val1 = (string)$value1->title;
        $val2 = (string)$value2->title;

        // needs to return 0 if equal
        // if first value is greater:
        //  if returning max heap: return positive
        //  if returning min heap: return negative
        // if second value is greater:
        //  if returning max heap: return negative
        //  if returning min heap: return positive

        // we're using minheap here
        if ($val1 == $val2) {
            return 0;
        } elseif ($val1 > $val2) {
            return -1;
        } else {
            return 1;
        }
    }
}

try {
    $data = new SimpleXMLIterator('./common/data/courses.xml', 0, true);
} catch (Exception $e) {
    echo $e->getMessage();
}
//$data = file_get_contents('./common/data/courses.json');
//$data = json_decode($data);

$courses = new SortCourses();

foreach ($data as $item) {
    $courses->insert($item);
}

foreach ($courses as $course) {
    echo $course->title . '<br>';
}