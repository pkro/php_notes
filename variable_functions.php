<?php
require "_util.php";

foreach (new FilesystemIterator('files') as $image) {
    if ($image->isFile() && in_array(strtolower($image->getExtension()), ['png', 'jpg', 'gif'])) {
        ["mime" => $mime] = getimagesize($image->getRealPath());
        $imgFunc = "imagecreatefrom" . substr($mime, strpos($mime, '/') + 1);
        $images[] = $imgFunc($image->getRealPath());
    }
}

