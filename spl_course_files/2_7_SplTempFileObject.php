<?php
$currencies = ['australia $', 'us $', 'Euro', 'yen', 'pound', 'franc'];
$currencyIterator = new ArrayIterator($currencies);

function createEntry()
{
    global $currencyIterator;
    $entry = ['currency' => $currencyIterator->current(), 'rate' => mt_rand() / mt_getrandmax()];
    $currencyIterator->next();
    return $entry;
}

$rates = array_map(
    'createEntry',
    array_fill(0, count($currencies), 0));

if (isset($_POST['download'])) {
    $titles = array_keys($rates[0]);

    $file = new SplTempFileObject();

    $file->fputcsv($titles);

    foreach ($rates as $row) {
        //$file->fputcsv([$row['currency'], $row['rate']]);
        $file->fputcsv($row);
    }

    // otherwise it will be empty when downloaded
    $file->rewind();

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="rates.csv"');
    $file->fpassthru();
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table>
    <tr>
        <th>Currency</th>
        <th>exchange rate</th>
    </tr>
    <?php
    foreach ($rates as $row) {
        echo "<tr><td>{$row['currency']}</td><td>{$row['rate']}</td></tr>";
    }
    ?>
</table>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <input type="submit" name="download" value="Download">

</form>
</body>
</html>

