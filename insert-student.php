<?php

use Alura\Pdo\Domain\Model\Student;
require_once 'vendor/autoload.php';

$dir = __DIR__ . '/BASE.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $dir);

$student = new Student(
    null,
    'Larissa M. Santo',
    new \DateTimeImmutable('1996-06-17')
);

$qry1 = "INSERT INTO SA0010 (SA0_NAME, SA0_NASC) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}')";

$pdo->exec($qry1);