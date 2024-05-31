<?php

use Alura\Pdo\Domain\Model\Student;
require_once 'vendor/autoload.php';

$pdo = \Alura\Pdo\Infraestructure\Persistence\ConnectionCreator::Connection();

// Buscando estudantes cadastrados
$statement = $pdo->query('SELECT * FROM SA0010');

/*
    Instanciando o Statement em Objetos sem comprometer os recursos de memória
        Instancia um objeto e depois o descarta para gerar um novo.
*/
while($studentData = $statement->fetch(PDO::FETCH_ASSOC)){
    $student = new Student(
        $studentData['SA0_ID'],
        $studentData['SA0_NAME'],
        new \DateTimeImmutable($studentData['SA0_NASC'])
    );

    echo "Nome: {$student->name()}" . PHP_EOL;
    echo "Idade: {$student->age()} anos" . PHP_EOL;
    echo PHP_EOL;
}
