<?php

require_once('../compareweather.php');
require_once('../classes/comparison.php');
require_once('../classes/location.php');

$locations = [
    new Location(Config::firstCityName(), Config::firstCityLatitude(), Config::firstCityLongitude()),
    new Location(Config::secondCityName(), Config::secondCityLatitude(), Config::secondCityLongitude()),
];

$comparison = new Comparison($locations);
echo $comparison->render();
