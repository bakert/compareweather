<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

date_default_timezone_set('UTC');

function q($s) {
	return htmlentities($s);
}
