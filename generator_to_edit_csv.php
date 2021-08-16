<?php

function csv_processor(string $csv_file, bool $hasHead = true, $separator = ",")
{
    $csv = new SplFileObject($csv_file);
    $csv->setCsvControl($separator);

    $linesRead = 0;
    while ($line = $csv->fgetcsv()) {
        yield $line;
        $linesRead++;
    }
    unset($csv);
    return $linesRead;
}

$source = csv_processor('parking.csv');
if($source->valid()) {
    $destination = new SplFileObject('parking_processed.csv', 'w');
    $source->current();
    $destination->fputcsv(['address', 'lattitude', 'longitude']);
    foreach ($source as $data) {
        if (!empty($data[9]) && preg_match('/(-?\d+\.\d+),\s(-?\d+\.\d+)/', $data[9], $matches)) {
            $output = [ucwords(strtolower($data[1])), $matches[1], $matches[2]];
            $destination->fputcsv($output);
        }
    }
}

echo $source->getReturn() . ' lines processed';

echo '</pre>';


