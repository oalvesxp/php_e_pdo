<?php

use Alura\Pdo\Domain\Model\Student;
require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Osvaldo A. Neto',
    new \DateTimeImmutable('1997-02-26')
);

echo $student->age();
