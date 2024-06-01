<?php

namespace Alura\Pdo\Domain\Model;

class Student 
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;

    // Construtor
    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    // Se o Aluno for criado sem ID
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

    // Atualiza o Nome cadastrado
    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    // Calcula Idade
    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }
}
