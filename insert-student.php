<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infraestructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::Connection();
$studentRepository = new PdoStudentRepository($connection);

// Reservando a transação
$connection->beginTransaction();

try{
    // Cadastrando novo Aluno
    $student = new Student(
        null,
        'Natália M. Batista',
        new \DateTimeImmutable('1986-09-10')
    );

    $studentRepository->save($student);
    $connection->commit();

} catch (\PDOException $e) {
    $connection->rollBack();
    echo $e->getMessage();
}
