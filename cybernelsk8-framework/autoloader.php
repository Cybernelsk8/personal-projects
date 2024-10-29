<?php


class Autoloader {

    protected static $files = [
        __DIR__ . '/core/Helpers/app.php',
        __DIR__ . '/core/Helpers/http.php',
        __DIR__ . '/core/Helpers/session.php',
        __DIR__ . '/core/Helpers/string.php',
        __DIR__ . '/core/Helpers/auth.php',
    ];

    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
        self::loadHelpers();
    }

    public static function autoload($class) {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = __DIR__ . '/' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new Exception("No se pudo cargar la clase $class en el archivo $file.");
        }
    }

    protected static function loadHelpers() {
        foreach (self::$files as $file) {
            if (file_exists($file)) {
                require_once $file;
            } else {
                throw new Exception("No se pudo cargar el archivo de helper: $file");
            }
        }
    }
}
