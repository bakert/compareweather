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
        $key = static::camelToDotSeparated($name);
        if (isset(static::$config[$key])) {
            return static::$config[$key];
        } else {
            return null;
        }
    }

    protected static function camelToDotSeparated($s) {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1.$2', $s));
    }
}

