<?php

class Database
{
    public static function connect(): PDO
    {
        $host = '127.0.0.1';
        $port = 3306;
        $dbname = 'bdisildemo';
        $user = 'root';
        $password = '';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}
