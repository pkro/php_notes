<?php
// Load XML as SimpleXMLIterator
$courses = simplexml_load_file('common/data/courses.xml', 'SimpleXMLIterator');

// Get the total number of top-level elements in the XML
$total = $courses->count();

// Set the number of items to show at a time
$step = 5;

// Get the start position
if (isset($_GET['start']) && $_GET['start'] < $total && $_GET['start'] >= 0) {
    $start = $_GET['start'];
} else {
    $start = 0;
}

// Create an instance of LimitIterator only if $start is a number
if (is_numeric($start)) {
    $courses = new LimitIterator($courses, $start, $step);
    $links = true;
} else {
    $links = false;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Using LimitIterator</title>
    <style>
        body {
            font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
            color: #0F0F0F;
            background-color: #FFFFFF;
            margin-left: 30px;
            max-width: 660px;
        }

        h2 {
            margin-bottom: 0.25em;
        }

        .author {
            margin-top: 0;
            margin-bottom: 0;
            font-style: italic;
        }

        p {
            margin-top: 0.25em;
            margin-left: 30px;
            max-width: 600px;
        }

        #prev {
            float: left;
        }

        #next {
            float: right;
        }
    </style>
</head>
<body>
<h1>Learn PHP with lynda.com</h1>
<?php if (!$courses) { ?>
    <p>Sorry, data not available.</p>
<?php } else {
    foreach ($courses as $course) {
        echo "<h2>$course->title</h2>";
        echo "<p class='author'>$course->author ($course->duration)</p>";
        echo "<p>$course->description</p>";
    }
    // Create previous and next links only if $links is true
    // Show previous link only if $start is greater than zero
    if ($links && $start > 0) {
        echo '<p id="prev"><a href="' . $_SERVER['PHP_SELF'] . '?start=' . ($start - $step) . '">Previous</a></p>';
    }
    // Hide next link if there are no more elements to show
    if ($links && ($start + $step) < $total) {
        echo '<p id="next"><a href="' . $_SERVER['PHP_SELF'] . '?start=' . ($start + $step) . '">Next</a></p>';
    }
}
?>
</body>
</html>
