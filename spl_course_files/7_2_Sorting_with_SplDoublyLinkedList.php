<?php

try {
    $data = new SimpleXMLIterator('./common/data/courses.xml', 0, true);

} catch (Exception $e) {
    echo $e->getMessage();
}


function getLastName($author)
{
    $pos = strrpos($author, ' ');
    return substr($author, $pos + 1);
}

// sort by authors last name
// this most likely isn't faster than using usort (?)
$courses = new SplDoublyLinkedList();

foreach ($data as $item) {
    if ($courses->isEmpty()) {
        $courses->push($item);
    } else {
        $lastName = getLastName($item->author);
        $courses->rewind(); // go to beginning of list
        // go to the position where we need to insert
        while ($courses->valid() && getLastName($courses->current()->author) <= $lastName) {
            $courses->next();
        }
        $courses->add($courses->key(), $item);
    }
}

foreach ($courses as $course) {
    echo $course->author . ": " . $course->title . '<br>';
}

echo "reversed---------------------------------------------------------";
$courses->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
foreach ($courses as $course) {
    echo $course->author . ": " . $course->title . '<br>';
}
