<?php

/*
 * Interface to api.forecast.io weather service.
 *
 * See: https://developer.forecast.io/docs/v2
 */
class ForecastIo {

    public function __construct() {
        $this->apiKey = Config::forecastIoApiKey();
    }

    public function get($location, $time = null) {
        $url = 'http://api.forecast.io/forecast/' . rawurlencode($this->apiKey) . '/';
        $url .= rawurlencode($location->latitude()) . ',' . rawurlencode($location->longitude());
        if ($time) {
            $url .= ',' . rawurlencode($time);
        }
        $url .= '?units=si&exclude=currently,minutely,hourly,alerts,flags';
        $responseBody = file_get_contents($url);
        return json_decode($responseBody, true);
    }
}
