<?php

class Weather {
    public function __construct($location, $icon, $temperature) {
        $this->location    = $location;
        $this->icon        = $icon;
        $this->temperature = $temperature;
    }

    public function location() {
        return $this->location;
    }

    public function icon() {
        return $this->icon;
    }

    public function temperature() {
        return $this->temperature;
    }
}
