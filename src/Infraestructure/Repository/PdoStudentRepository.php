<?php

namespace Alura\Pdo\Infraestructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infraestructure\Persistence\ConnectionCreator;

class PdoStudentRepository implements StudentRepository
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::Connection();
    }

    public function allStudents(): array
    {
        //todo
    }

    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        
    }

    public function save(Student $student): bool
    {
        
    }

    public function remove(Student $student): bool
    {
        
    }
}
