<?php

try {
    $xml = new SimpleXMLIterator('common/data/courses.xml', 0, true);
    // why doesn't $course->level === "Intermediate" work?
    //$onlyIntermediate = new CallbackFilterIterator($xml, fn($course) => $course->level == "Intermediate");
    $onlyIntermediate = new CallbackFilterIterator($xml, function ($current, $key, $iterator) {
        return $current->level == "Intermediate";
    });
} catch (Exception $e) {
    echo $e->getMessage();
}

foreach ($onlyIntermediate as $course) {
    echo $course->title . " with <b>" . $course->author . "</b> (Level: " . $course->level . ")<br><br>";
}

