<?php

use Alura\Pdo\Domain\Model\Student;
require_once 'vendor/autoload.php';

$dir = __DIR__ . '/BASE.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $dir);

// Buscando estudantes cadastrados
$statement = $pdo->query('SELECT * FROM SA0010');

/*
    Indexando o Statement retornado (retorna em 2 tipos de dados)
        Array Associativo
        Strings
*/
//var_dump($statement->fetchAll());
//echo $studentList[0]['SA0_NASC'];

/*
    Passando um parâmetro para classificar o tipo de dados do fetch
*/
//$studentList = $statement->fetchAll(PDO::FETCH_ASSOC);
//var_dump($studentList);


/*
    Instanciando Objetos com os dados carregados pelo fetch
        Atenção: Se a tabela for muito grande pode estourar
            os recursos de memória do servidor.
*/
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

// Para cada aluno
foreach ($studentDataList as $studentData) {
    // Dados do construtor
    $studentList[] = new Student(
        $studentData['SA0_ID'],
        $studentData['SA0_NAME'],
        new \DateTimeImmutable($studentData['SA0_NASC'])
    );
}

var_dump($studentList);
