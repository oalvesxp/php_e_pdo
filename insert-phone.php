<?php

use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;
require_once 'vendor/autoload.php';

$connection = ConnectionCreator::Connection();

$connection->beginTransaction();

try{
    $connection->exec("
        INSERT INTO SB0010
            (
                SB0_ACOD
                , SB0_NUM
                , SB0_SID
            ) 
        VALUES
            ('11', '40097174', 1)
            , ('11', '34024232', 1)
            , ('11', '20074992', 2)
            , ('11', '50274232', 3)
            , ('11', '62473123', 4)
    "); 

    $connection->commit();

} catch (\PDOException $e) {
    $connection->rollBack();
    echo $e->getMessage();
}