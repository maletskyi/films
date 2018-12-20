<?php

namespace App\Repositories;

use PDO;

abstract class AbstractRepository
{
    protected $pdo;

    public function __construct()
    {
        $settings = require dirname(__DIR__, 2).'/config/db.php';

        $host    = $settings['host'];
        $db      = $settings['db'];
        $user    = $settings['user'];
        $pass    = $settings['pass'];
        $charset = $settings['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
//            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }
}