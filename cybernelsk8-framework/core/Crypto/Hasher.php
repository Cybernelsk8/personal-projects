<?php

namespace Core\Crypto;

interface Hasher {
    public static function hash(string $input) : string;
    public static function verify(string $input, string $hash) : bool;
}