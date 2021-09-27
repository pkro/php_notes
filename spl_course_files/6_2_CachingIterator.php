<?php

try {
    $xml = new SimpleXMLIterator('./common/data/courses.xml', 0, true);
} catch (Exception $e) {
    echo $e->getMessage();
}

foreach ($xml as $course) {
    echo '<h2>' . $course->title . "</h2><br>";
    echo '<p>' . $course->description . "</p><br>";
    $software = $course->software->children();
    $numSoftware = count($software);
    echo '<p>Software: ';
    if ($numSoftware == 1) {
        echo $software[0];
    } elseif ($numSoftware == 2) {
        echo $software[0] . ' and ' . $software[1];
    } else {
        $software = new CachingIterator($software);
        foreach ($software as $type) {
            if ($software->hasNext()) {
                echo "$type, ";
            } else {
                echo "and $type";
            }
        }
    }


    echo '</p>';

}