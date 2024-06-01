<?php

use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infraestructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';


$pdo = ConnectionCreator::Connection();
$repository = new PdoStudentRepository($pdo);

$studenList = $repository->allStudents();

var_dump($studenList);