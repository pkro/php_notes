<?php
function permutations(array $elements) {
    $len = count($elements);
    $perms = 0;
    if ($len <= 1) {
        yield $elements;
    } else {
        foreach(permutations(array_slice($elements, 1)) as $permutation) {
            foreach(range(0, $len - 1) as $i) {
                yield array_merge(
                    array_slice($permutation, 0, $i),
                    [$elements[0]],
                    array_slice($permutation, $i)
                );
                $perms++;
            }
        }
    }
    return $perms;
}

$perms = permutations(['A', 'B', 'C', 'D', 'E', 'F']);
foreach ($perms as $perm) {
    echo implode(' ', $perm) . '<br>';
}
echo $perms->getReturn() . ' permutations generated';