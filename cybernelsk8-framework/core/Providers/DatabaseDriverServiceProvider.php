<?php

namespace Core\Providers;

use Core\Database\Drivers\DatabaseDriver;
use Core\Database\Drivers\PdoDriver;
use Core\Session\PhpNativeSessionDrive;
use Core\Session\SessionDrive;

class DatabaseDriverServiceProvider implements ServiceProvider {
    public function registerServices(){
        match(config("database.connection","mysql")){
            "mysql","mariaDB","pgsql" => singleton(DatabaseDriver::class,PdoDriver::class),
        };
    }
}