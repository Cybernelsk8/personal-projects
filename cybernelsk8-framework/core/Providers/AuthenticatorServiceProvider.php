<?php

namespace Core\Providers;

use Core\Auth\Authenticators\Authenticator;
use Core\Auth\Authenticators\JWTAuthenticator;
use Core\Auth\Authenticators\SessionAuthenticator;

class AuthenticatorServiceProvider implements ServiceProvider {
    public function registerServices() {
        match (config("auth.method","session")){
            "session" => singleton(Authenticator::class, SessionAuthenticator::class),
            "jwt" => singleton(Authenticator::class,JWTAuthenticator::class),
        };
    }
}