<?php

namespace Core\Crypto;

class Bcrypt implements Hasher {
    
    public static function hash(string $input): string {
        return password_hash($input, PASSWORD_BCRYPT);
    }

    public static function verify(string $input, string $hash): bool {
        return password_verify($input,$hash);
    }
}