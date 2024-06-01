<?php

namespace Alura\Pdo\Domain\Model;

class Phone
{
    private ?int $id;
    private string $areaCode;
    private string $number;

    /** Construtor da Class Phone */
    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    /** Formata o Telefone (00) 00000000 */
    public function formattedPhone(): string
    {
        return "($this->areaCode) $this->number";
    }
}