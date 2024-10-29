<?php

namespace App\Providers;

use Core\Kernel;
use Core\Providers\ServiceProvider;
use Core\Routing\Route;

class RouteServiceProvider implements ServiceProvider {
    public function registerServices() {
        Route::load(Kernel::$root."/routes");
    }
}