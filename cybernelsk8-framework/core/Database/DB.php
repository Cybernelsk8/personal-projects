<?php

namespace Core\Database;

use Core\Database\Drivers\DatabaseDriver;

class DB {
    public static function statement(string $query, array $binds = []) {
        return app(DatabaseDriver::class)->statement($query,$binds);
    }
}