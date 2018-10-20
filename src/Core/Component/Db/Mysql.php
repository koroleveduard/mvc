<?php

namespace App\Core\Component\Db;

use App\Core\Helper\ArrayHelper;
use PDO;

class Mysql implements DBAdapter
{
    private $connection;

    public function __construct(array $config)
    {
        $host = ArrayHelper::getValue($config, 'host', '127.0.0.1');
        $username = ArrayHelper::getValue($config, 'username', null);
        $password = ArrayHelper::getValue($config, 'password', null);
        $dbname = ArrayHelper::getValue($config, 'dbname', null);
        $dsn = "mysql:dbname=${dbname};host=${host}";

        try {
            $this->connection = new \PDO($dsn, $username, $password);
        } catch (\PDOException $e) {
            echo 'Database connection error with message: ' . $e->getMessage();
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
