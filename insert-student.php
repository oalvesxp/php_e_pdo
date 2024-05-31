<?php

use Alura\Pdo\Domain\Model\Student;
require_once 'vendor/autoload.php';

$dir = __DIR__ . '/BASE.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $dir);

$student = new Student(
    null,
    'Lucas V. Almeida',
    new \DateTimeImmutable('1993-08-03')
);

// Problemas de segurança
//$qry1 = "INSERT INTO SA0010 (SA0_NAME, SA0_NASC) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}')";

// Evitando SQL Injection 
$qry1 = "INSERT INTO SA0010 (SA0_NAME, SA0_NASC) VALUES (?, ?)";

$statement = $pdo->prepare($qry1);
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

if ($statement->execute()) {
    echo "Aluno cadastrado com sucesso!";
}
