<?php

namespace Core\Database\Drivers;

use PDO;

class PdoDriver implements DatabaseDriver {

    protected ?PDO $pdo;

    public function connect( string $protocolo, string $host, int $port, string $database, string $username, string $password) {
        $dsn = "$protocolo:host=$host;port=$port;dbname=$database";
        $this->pdo = new PDO($dsn,$username,$password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function close(){
        $this->pdo = null;
    }

    public function statement(string $query, array $binds = []) : mixed {
        $statement = $this->pdo->prepare($query);
        $statement->execute($binds);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}