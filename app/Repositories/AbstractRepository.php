<?php

namespace App\Repositories;

use App\App;
use PDO;

abstract class AbstractRepository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = App::$connection;
    }
}