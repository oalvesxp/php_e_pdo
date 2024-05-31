<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infraestructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::Connection();
$studentRepository = new PdoStudentRepository($connection);

// Reservando a transação
$connection->beginTransaction();

// Cadastrando novo Aluno
$student = new Student(
    null,
    'Wellington C. Santos',
    new \DateTimeImmutable('1997-04-02')
);

$studentRepository->save($student);

$connection->commit();
