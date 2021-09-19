<?php

function getDistance(array $location1, array $location2, $precision = 0, $useMiles = true) {
    // Get the Earth's radius in miles or kilometers
    $radius = $useMiles ? 3955.00465 : 6364.963;
    // Convert latitude from degrees to radians
    $lat1 = deg2rad($location1[0]);
    $lat2 = deg2rad($location2[0]);
    // Get the difference between longitudes and convert to radians
    $long = deg2rad($location2[1] - $location1[1]);
    // Calculate the distance
    return round(acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($long)) * $radius, $precision);
}
$ny = [40.758895,-73.9873197];
$la = [33.914329,-118.2849236];
$trafalgar = [51.5080917,-0.1291379];
$palace = [51.5013673,-0.1440787];

echo getDistance($ny, $la, 0, false);