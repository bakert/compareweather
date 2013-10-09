<?php

require_once __DIR__ . '/../compareweather.php';
require_once __DIR__ . '/../classes/location.php';

class Scheduled {

	public static function run() {
        $locations = Location::init();
        foreach ($locations as $location) {
            // This has the side effect of fetching all missing data and storing it in the database.
            $location->averageTemperature(Config::startDate(), date('Y-m-d'));
        }
	}
}

if (basename($argv[0]) === basename(__FILE__)) { Scheduled::run(); }
