<?php

class Store {

	public function __construct() {
		$connectionString = Config::databaseType() . ':host=' . Config::databaseHost() . ';dbname=' . Config::databaseName() . ';charset=utf8';
	    $this->connection = new PDO($connectionString, Config::databaseUsername(), Config::databasePassword());
	}

	public function load($location) {
		$data = [];
		$sql = 'SELECT `date`, icon, temperature FROM weather WHERE latitude = ? AND longitude = ?';
		$args = [$location->latitude(), $location->longitude()];
		$statement = $this->connection->prepare($sql);
		$statement->execute($args);
		$results = $statement->fetchAll();
		foreach ($results as $row) {
			$date = date('Y-m-d', strtotime($row['date']));
			$data[$date] = new Weather($location, $row['icon'], $row['temperature']);
		}
		return $data;
	}

	public function save($date, $weather) {
		$sql = 'INSERT INTO weather (`date`, latitude, longitude, icon, temperature) VALUES (?, ?, ?, ?, ?)';
		$args = [$date, $weather->location()->latitude(), $weather->location()->longitude(), $weather->icon(), $weather->temperature()];
		$this->connection->prepare($sql)->execute($args);
	}
}
