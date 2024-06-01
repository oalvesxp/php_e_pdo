<?php

use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infraestructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::Connection();
$repository = new PdoStudentRepository($pdo);

/** @var Student[] $studentList */
$studentList = $repository->studentsWithPhones();

var_dump($studentList);
