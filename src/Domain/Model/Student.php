<?php

namespace Alura\Pdo\Domain\Model;

class Student 
{
    /** Declarando Variáveis */
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;

    /** @var Phone[] */
    private array $phones = [];

    /** Construtor da Class Aluno */
    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    /** Verifica se o Aluno já possui um ID */
    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new \DomainException('Você só pode definir o ID uma vez!');
        }

        $this->id = $id;
    }

    public function id(): ?int 
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    /** Atualiza o Nome do Aluno */
    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    /** Calcula Idade */
    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function addPhone(Phone $phone): void 
    {
        $this->phones[] = $phone;    
    }

    /** @return Phone[] */
    public function phones(): array 
    {
        return $this->phones;
    }
}
