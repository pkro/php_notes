<?php
$courses = simplexml_load_file('./common/data/courses.xml');
// Collect titles, authors, and descriptions into arrays
// SimpleXMLElements must be cast to strings
foreach ($courses as $course) {
    $titles[] = (string)$course->title;
    $authors[] = (string)$course->author;
    $descriptions[] = (string)$course->description;
}
// Sort the arrays by titles and convert to iterators
array_multisort($titles, $authors, $descriptions);
$titles = new ArrayIterator($titles);
$authors = new ArrayIterator($authors);
$descriptions = new ArrayIterator($descriptions);

// Create an instance of MultipleIterator to merge the arrays
$courses = new MultipleIterator(MultipleIterator::MIT_KEYS_ASSOC);
$courses->attachIterator($titles, 'title');
$courses->attachIterator($authors, 'author');
$courses->attachIterator($descriptions, 'description');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>MultipleIterator Example</title>
    <style>
        body {
            font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
            color: #0F0F0F;
            background-color: #FFFFFF;
            margin-left: 30px;
        }

        h2 {
            margin-bottom: 0;
        }

        .author {
            margin-top: 0.25em;
            font-style: italic;
        }

        p {
            margin-left: 30px;
            max-width: 600px;
        }
    </style>
</head>
<body>
<h1>PHP Courses</h1>
<?php
foreach ($courses as $course) {
    echo '<h2>' . $course['title'] . '</h2>';
    echo '<p class="author">' . $course['author'] . '</p>';
    echo '<p>' . $course['description'] . '</p>';
}
?>
</body>
</html>
