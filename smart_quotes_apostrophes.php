<?php
$original = <<< EOL
"This is a test of replacing straight quotes with smart quotes," he said. "Let's see if it's working. One of Shakespeare's great plays is 'A Midsummer Night's Dream'."
EOL;

function smartQuotes($text) {
    $pattern2replacement = [
        // \1 = repeat first capturing group: "
        '/(")([^"]+?)\1/'       => "\u{201C}$2\u{201D}", // double quotes

        // (?<!\w) = negative look behind (doesn't start with a word)
        // ' = '
        // (?=\w) = positive lookahead (must continue with a word)
        "/(?<!\w)'(?=\w)/"      => "\u{2018}", // left single quote
        "/(?<=\w)'(?=\w)/"      => "\u{2019}", // apostrophe
        // positive look behind and negative lookahead
        "/(?<=[\w,.!?])'(?!\w)/" => "\u{2019}" // right single quote
    ];

    return preg_replace(array_keys($pattern2replacement), array_values($pattern2replacement), $text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Quotes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Smart Quotes</h1>
<p><?= smartQuotes($original); ?></p>
</body>
</html>