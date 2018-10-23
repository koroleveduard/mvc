<?php

namespace App\Core\Component\Db;

use PDO;

interface DBAdapter
{
    public function getConnection(): PDO;
}