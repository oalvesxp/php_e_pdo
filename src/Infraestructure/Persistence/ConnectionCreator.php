<?php

namespace Alura\Pdo\Infraestructure\Persistence;
use PDO;

class ConnectionCreator
{
    public static function Connection(): \PDO
    {
        $dir = __DIR__ . '/../../../BASE.sqlite';
        $connection = new PDO(dsn: 'sqlite:' . $dir);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    }
}
