<?php
$testTrue = 1;
$testFalse = 0;

// normal ternary:
// value = condition ? [value if true] : [value if false]
$x = $testTrue == 1 ? 'A' : 'B'; // A

// if the truthy/falsy value evaluates to true, it is itself
// used as the value, otherwise the value after "?:"
// value = [truthy/falsy value] ?: [value if false]
$x = $testFalse ?: 'B'; // 1

// Null coalescing operator
// value = value ?? [default if value is null]
// doesn't warn because of undefined variable (that's the whole point)
$x = $notDefined ?? 'A'; // A
$defined = 'i am defined';
$x = $defined ?? 'A'; // "i am defined"

// it always uses the first value that is not null and can easily be chained
// useful for e.g. checking for checkboxes (which aren't included in $_POST
// if they are not checked)