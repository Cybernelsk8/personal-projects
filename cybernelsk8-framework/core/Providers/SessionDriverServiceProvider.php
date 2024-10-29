<?php

namespace Core\Providers;

use Core\Session\PhpNativeSessionDrive;
use Core\Session\SessionDrive;

class SessionDriverServiceProvider implements ServiceProvider {
    public function registerServices(){
        match(config("session.drive","native")){
            "native" => singleton(SessionDrive::class,PhpNativeSessionDrive::class),
        };
    }
}