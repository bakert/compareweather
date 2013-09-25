<?php

require_once(dirname(__FILE__) . '/../compareweather.php');

/*
 * Interface to api.forecast.io weather service.
 *
 * Usage:
 *
 *     $forecast = new Forecast();
 *     $forecast->forecast($lat, $lng, $time);
 *
 * See: https://developer.forecast.io/docs/v2
 */
class Forecast {

    public function __construct() {
        $this->apiKey = Config::apiKey();
    }

    public function forecast($lat, $lng, $time = null) {
        $url = 'http://api.forecast.io/forecast/' . rawurlencode($this->apiKey) . '/';
        $url .= rawurlencode($lat) . ',' . rawurlencode($lng);
        if ($time) {
            $url .= ',' . rawurlencode($time);
        }
        $responseBody = file_get_contents($url);
        print_r($responseBody);
    }
}

