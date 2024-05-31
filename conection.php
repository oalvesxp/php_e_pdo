<?php

$dir = __DIR__ . '/BASE.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $dir);

$qry = '
    CREATE TABLE IF NOT EXISTS
        SA0010 (
            SA0_ID INTEGER PRIMARY KEY
            , SA0_NAME VARCHAR(100)
            , SA0_NASC VARCHAR
        );

    CREATE TABLE IF NOT EXISTS
        SB0010 (
            SB0_ID INTEGER PRIMARY KEY
            , SB0_ACOD VARCHAR
            , SB0_NUM VARCHAR(100)
            , SB0_SID INTEGER
            , FOREIGN KEY(SB0_SID) REFERENCES SA0010(SA0_ID)
        );
';

$pdo->exec($qry);
