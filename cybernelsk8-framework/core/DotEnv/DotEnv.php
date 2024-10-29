<?php

namespace Core\DotEnv;

class DotEnv {
    
    protected static $path;

    public static function load($path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException("El archivo .env no existe en la ruta: $path");
        }
        self::$path = $path;

        $lines = file(self::$path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($key, $value) = explode('=', $line, 2);

            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"");

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
}