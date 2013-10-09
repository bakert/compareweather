<?php

// Configuration information loaded from a file.
class Config {
    const CONFIG_FILE = 'config';
    const DIVIDER = ' = ';

    protected static $config;

    protected static function init() {
        $path = __DIR__ . '/' . static::CONFIG_FILE;
        if (!file_exists($path)) {
            throw new Exception('Configuration file not found at ' . $path);
        }
        static::$config = [];
        $rawConfig = file_get_contents($path);
        foreach (explode("\n", $rawConfig) as $line) {
            if (strpos($line, static::DIVIDER) === false) {
                continue;
            }
            list($key, $value) = explode(static::DIVIDER, $line);
            static::$config[$key] = $value;
        }
    }

    public static function __callStatic($name, array $args) {
        if (!isset(static::$config)) {
            static::init();
        }
        if (isset(static::$config[$name])) {
            return static::$config[$name];
        } else {
            return null;
        }
    }
}

