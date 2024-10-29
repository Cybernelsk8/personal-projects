<?php

namespace Core\Providers;

use Core\Server\PhpNativeServer;
use Core\Server\Server;

class ServerServiceProvider implements ServiceProvider{
    public function registerServices() {
        singleton(Server::class,PhpNativeServer::class);
    }
}