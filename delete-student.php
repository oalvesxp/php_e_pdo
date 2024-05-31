<?php

require_once 'vendor/autoload.php';

$dir = __DIR__ . '/BASE.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $dir);

// Passando a query pelo proprio 'prepare', agilizando o processo de condificação
// Utilizando bind de valor por campo nomeado ':value'
// Definindo o tipo de valor do bindValue, PDO::PARAM_TYPE
$statement = $pdo->prepare('DELETE FROM SA0010 WHERE SA0_ID = :id');
$statement->bindValue(':id', 3, PDO::PARAM_INT);
$statement->execute();
