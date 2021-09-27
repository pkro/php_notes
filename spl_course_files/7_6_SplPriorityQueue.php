<?php

$error_log_path = '/opt/lampp/logs/php_error_log';

$log = new SplFileObject($error_log_path);
// hack - go way beyond actual file length and php will correct it to the actual last line
$log->seek(PHP_INT_MAX);
$lastLine = $log->key();
$lines = new LimitIterator($log, $lastLine - 50, $lastLine);

function setPriority($line)
{
    if (stristr($line, 'fatal error')) {
        return 10;
    }
    if (stristr($line, 'fatal error')) {
        return 8;
    }
    if (stristr($line, 'warning')) {
        return 7;
    }
    if (stristr($line, 'deprecated')) {
        return 5;
    }
    if (stristr($line, 'parse error')) {
        return 3;
    }
    if (stristr($line, 'notice')) {
        return 1;
    }

    return 0;
}

$prio = new SplPriorityQueue();

foreach ($lines as $line) {
    $prio->insert($line, setPriority($line));
}

foreach ($prio as $line) {
    echo $line . "<br><br>";
}