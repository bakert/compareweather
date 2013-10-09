<?php

require_once __DIR__ . '/../classes/forecastio.php';
require_once __DIR__ . '/../classes/store.php';
require_once __DIR__ . '/../classes/weather.php';

class Location {

    public function __construct($name, $latitude, $longitude) {
        $this->name       = $name;
        $this->latitude   = $latitude;
        $this->longitude  = $longitude;
        $this->forecastIo = new ForecastIo();
        $this->store      = new Store();
        $this->data       = $this->store->load($this);
    }

    public function name() {
        return $this->name;
    }

    public function latitude() {
        return $this->latitude;
    }

    public function longitude() {
        return $this->longitude;
    }

    public function icon($date = null) {
        return $this->property('icon', $date);
    }

    public function temperature($date = null) {
        return $this->property('temperature', $date);
    }

    public function averageTemperature($beginDate, $endDate) {
        $date = $beginDate;
        list($n, $total) = [0.0, 0.0];
        while ($date <= $endDate) {
            $n += 1.0;
            $total += $this->temperature($date);
            $date = date('Y-m-d', strtotime($date) + (24 * 60 * 60));
        }
        return $total / $n;
    }

    protected function retrieve($date) {
        $time = $this->middayAtThisLocation($date);
        $data = $this->forecastIo->get($this, $time);
        $daily = $data['daily']['data'][0];
        $weather = new Weather($this, $daily['icon'], $daily['temperatureMax']);
        $this->store->save($date, $weather);
        $this->data[$date] = $weather;
    }

    protected function property($property, $date) {
        if (!$date) {
            $date = date('Y-m-d');
        }
        if (!isset($this->data[$date])) {
            $this->retrieve($date);
        }
        return $this->data[$date]->$property();
    }

    protected function middayAtThisLocation($date) {
        $hoursAwayFromGreenwich = $this->longitude() / 15.0;
        $time = strtotime($date) + (12 * 60 * 60) + (-$hoursAwayFromGreenwich * 60 * 60);
        return (int) round($time);
    }
}
