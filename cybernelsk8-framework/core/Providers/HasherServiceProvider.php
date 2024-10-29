<?php

namespace Core\Providers;

use Core\Crypto\Bcrypt;
use Core\Crypto\Hasher;

class HasherServiceProvider implements ServiceProvider {
    public function  registerServices() {
        match(config("hashing.hasher","bcrypt")){
            "bcrypt" => singleton(Hasher::class,Bcrypt::class),
        };
    }
}