<?php // HTML/JavaScript sanitization

$sanitize = true;

$html_string = "<div style=\"color: red; font-size: 30px;\">" .
    "This <strong>string</strong> contains text & " .
    "<span style=\"color: green;\">HTML</span>." .
    "</div>" .
    "<br />";

$javascript_string = "<script>alert('Gotcha!');</script>";

if ($sanitize) {
    echo htmlspecialchars($html_string);
    // &lt;div style="color: red; font-size: 30px;"&gt;This &lt;strong&gt;string&lt;/strong&gt; contains text &amp; &lt;span style="color: green;"&gt;HTML&lt;/span&gt;.&lt;/div&gt;&lt;br /&gt;
    //echo htmlentities($html_string);
    // &lt;div style="color: red; font-size: 30px;"&gt;This &lt;strong&gt;string&lt;/strong&gt; contains text &amp; &lt;span style="color: green;"&gt;HTML&lt;/span&gt;.&lt;/div&gt;&lt;br /&gt;
    //echo strip_tags($html_string);
    // This string contains text & HTML.

    // echo htmlspecialchars($javascript_string);
    // echo htmlentities($javascript_string);
    // echo strip_tags($javascript_string);

} else {
    echo $html_string;
    echo $javascript_string;
}

?>
