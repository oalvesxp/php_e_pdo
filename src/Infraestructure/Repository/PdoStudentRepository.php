<?php

namespace Alura\Pdo\Infraestructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
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

    /** Filtra Alunos cadastrados */
    public function allStudents(): array
    {
        $qry = 'SELECT * FROM SA0010';
        $stmt = $this->connection->query($qry);

        return $this->hydrateStudentList($stmt);
    }

    /** Filtra aniversariantes */
    public function studentsBirthAt(\DateTimeInterface $birthDate): array
    {
        $qry = 'SELECT * FROM SA0010 WHERE SA0_NASC = :birthDate';
        $stmt = $this->connection->prepare($qry);
        $stmt->bindValue(':birthDate', $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    /** Transfere dados da camada de Database para a de Negócios */
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

    /** Problema de performance SQL (n + 1)
    -- Filtra telefones do Aluno 
    private function fillPhonesOf(Student $student): void
    {
       $qry = 'SELECT SB0_ID, SB0_ACOD, SB0_NUM FROM SB0010 WHERE SB0_SID = ?';
       $stmt = $this->connection->prepare($qry);
       $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);
       $stmt->execute();

       $phoneDataList = $stmt->fetchAll();

       foreach ($phoneDataList as $phoneData) {
            $phone = new Phone(
                $phoneData['SB0_ID'],
                $phoneData['SB0_ACOD'],
                $phoneData['SB0_NUM']
            );

            $student->addPhone($phone);
       }

    }
    */

    /** Adiciona ou atualiza cadastro de Aluno */
    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    /** Cadastra novo Aluno */
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

    /** Atualiza cadastro do Aluno */
    private function  update(Student $student): bool
    {
        $qry = 'UPDATE SA0010 SET SA0_NAME = :name, SA0_NASC = :birthDate WHERE SA0_ID = :id';

        $stmt = $this->connection->prepare($qry);
        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birthDate', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /** Remove cadastro do Aluno */
    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM SA0010 WHERE ID = ?');
        $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stmt->execute();        
    }

    /** Cria lista de Alunos e adiciona os Telefones */
    public function studentsWithPhones(): array
    {
        $qry = '
            SELECT SA0.SA0_ID
                , SA0.SA0_NAME
                , SA0.SA0_NASC
                , SB0.SB0_ID
                , SB0.SB0_ACOD
                , SB0.SB0_NUM
            FROM SA0010 AS SA0
            INNER JOIN SB0010 AS SB0 ON
                SA0.SA0_ID = SB0.SB0_SID
        ';
        
        $stmt = $this->connection->prepare($qry);
        $result = $stmt->fetchAll();
        $studentList = [];

        foreach ($result as $row) {
            if (!array_key_exists($row['SA0_ID'], $studentList)) {
                $studentList[$row['SA0_ID']] = new Student(
                    $row['SA0_ID'],
                    $row['SA0_NAME'],
                    new \DateTimeImmutable($row['SA0_NASC'])
                );
            }

            $phone = new Phone(
                $row['SB0_ID'],
                $row['SB0_ACOD'],
                $row['SB0_NUM']
            );

            $studentList[$row['SA0_ID']->addPhone($phone)];
        }

        return $studentList;
    }
}
