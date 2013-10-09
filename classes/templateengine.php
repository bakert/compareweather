<?php

class TemplateEngine {

	public function __construct() {
		$this->mustacheEngine = new Mustache_Engine();
	}

	public function render($template, $args) {
		$templateString = file_get_contents(__DIR__ . "/../templates/{$template}.mustache");
		return $this->mustacheEngine->render($templateString, $args);
	}
}
