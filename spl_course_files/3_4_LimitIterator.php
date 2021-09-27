<?php
try {
    $xml = new SimpleXMLIterator('common/data/courses.xml', 0, true);
    $first10 = new LimitIterator($xml, 0, 10);
} catch (Exception $e) {
    echo $e->getMessage();
}

foreach ($first10 as $course) {
    echo $first10->getPosition() + 1 . ". " . $course->title . " with <b>" . $course->author . "</b> (Duration: " . $course->duration . ")<br><br>";
}
