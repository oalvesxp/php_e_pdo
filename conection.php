<?php

$pdo = \Alura\Pdo\Infraestructure\Persistence\ConnectionCreator::Connection();

echo 'Teste: OK';
$pdo->exec(statement:'CREATE TABLE SA0010 (SA0_ID INTEGER PRIMARY KEY, SA0_NAME VARCHAR(100), SA0_NASC VARCHAR);');
