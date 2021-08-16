<?php

function counter($num): Generator  {
    $i=1;
    $total = 0;
    while ($i <= $num) {
        $total += $i;
        yield $i++;
    }
    yield from theEnd();

    return $total;
}

function theEnd(): Generator
{
    yield 'this';
    yield 'is';
    yield 'the';
    yield 'end';
}

foreach (counter(3) as $value) {
    echo '<br>', $value;
}
// 123

$count = counter(5);

foreach ($count as $value) {
    echo '<br>', $value;
}
echo '<br>', $count->getReturn(); // 15
/*
1
2
3
this
is
the
end
1
2
3
4
5
this
is
the
end
15
*/