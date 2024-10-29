<?php

use Core\Config\Config;
use Core\Container\Container;
use Core\Kernel;

function app(string $class = Kernel::class) {
    return Container::resolve($class);
}

function singleton(string $class,string|callable|null $build = null) {
    return Container::singleton($class,$build);
}

function config(string $configuration, $default = null) {
    return Config::get($configuration,$default);
}

function env($key, $default = null) {
    return $_ENV[$key] ?? $default;
}