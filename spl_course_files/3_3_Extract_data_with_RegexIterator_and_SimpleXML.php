<?php
try {
    $xml = new SimpleXMLIterator('common/data/courses.xml', 0, true);
    // alternative:
    // $xml = simplexml_load_file('common/data/courses.xml', 'SimpleXMLIterator');
} catch (Exception $e) {
    echo $e->getMessage();
}

// get all courses fro Jo(h)n Peck
foreach ($xml as $course) { // $file is a SplFileInfo object
    $matches = new RegexIterator($course->author, '/joh?n peck/i');
    foreach ($matches as $match) {
        echo $course->title . " with <b>" . $match . "</b> (Duration: " . $course->duration . ")<br><br>";
    }
    echo $course->title;
}
