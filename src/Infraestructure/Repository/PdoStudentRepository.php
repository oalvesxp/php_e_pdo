<?php

namespace Alura\Pdo\Infraestructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use PDO;


class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    // Busca todos os Alunos cadastrados
    public function allStudents(): array
    {
        $qry = 'SELECT * FROM SA0010';
        $stmt = $this->connection->query($qry);

        return $this->hydrateStudentList($stmt);
    }

    // Filtra os aniversariantes
    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        $qry = 'SELECT * FROM SA0010 WHERE SA0_NASC = :birthDate';
        $stmt = $this->connection->prepare($qry);
        $stmt->bindValue(':birthDate', $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    // Transfere informações da camada do Database para a camada de Negócios
    private function hydrateStudentList(\PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll();
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['SA0_ID'],
                $studentData['SA0_NAME'],
                new \DateTimeImmutable($studentData['SA0_NASC'])
            );
        }

        return $studentList;
    }

    // Adiciona ou Atualiza o cadastro de Aluno
    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    // Cadastra novo Aluno
    private function insert(Student $student): bool
    {
        $qry = 'INSERT INTO SA0010 (SA0_NAME, SA0_NASC) VALUES (:name, :birthDate)';
        $stmt = $this->connection->prepare($qry);
        
        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birthDate' => $student->birthDate()->format('Y-m-d'),
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    // Atualiza cadastro
    private function  update(Student $student): bool
    {
        $qry = 'UPDATE SA0010 SET SA0_NAME = :name, SA0_NASC = :birthDate WHERE SA0_ID = :id';

        $stmt = $this->connection->prepare($qry);
        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birthDate', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Remove Aluno cadastrado no banco
    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM SA0010 WHERE ID = ?');
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stmt->execute();        
    }
}
