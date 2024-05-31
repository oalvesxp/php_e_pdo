<?php

namespace Alura\Pdo\Infraestructure\Persistence;
use PDO;

class ConnectionCreator
{
    public static function Connection(): \PDO
    {
        $dir = __DIR__ . '/../../../BASE.sqlite';
        return new PDO(dsn: 'sqlite:' . $dir);
    }
}
