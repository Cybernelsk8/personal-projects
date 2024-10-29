<?php


return [

    'boot' => [
        Core\Providers\ServerServiceProvider::class,
        Core\Providers\DatabaseDriverServiceProvider::class,
        Core\Providers\SessionDriverServiceProvider::class,
        Core\Providers\AuthenticatorServiceProvider::class,
        Core\Providers\HasherServiceProvider::class,
    ],

    'runtime' => [
        App\Providers\RuleServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],

];