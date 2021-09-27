<?php
$products = array(
    'Cameras' => array('DSLR', 'smartphone', 'compact'),
    'Lenses' => array('telephoto', 'wide angle', 'fisheye'),
    'Accessories' => array('tripod', 'camera bag', 'Filters' =>
        array('polarizing', 'UV', 'neutral density')));


// echoing insinde the overridden methods seems not great design

class UnorderedListBuilder extends RecursiveIteratorIterator
{
    public function beginIteration()
    {
        echo "<ul>\n";
    }

    public function endIteration()
    {
        echo "</ul>\n";
    }

    public function beginChildren()
    {
        echo "<ul>";
    }

    public function endChildren()
    {
        echo "</ul></li>";
    }
}

$iter = new RecursiveArrayIterator($products);
$iter = new UnorderedListBuilder($iter, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iter as $category => $item) {
    if ($iter->hasChildren()) {
        echo '<li>' . $category;
    } else {
        echo '<li>' . $item . '</li>';
    }
}
