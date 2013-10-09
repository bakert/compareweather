<?php

require_once '../compareweather.php';
require_once '../classes/comparison.php';
require_once '../classes/location.php';

$locations = Location::init();
$comparison = new Comparison($locations);
echo $comparison->render();
