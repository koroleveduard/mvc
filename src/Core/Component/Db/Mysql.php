<?php

namespace App\Core\Component\Db;

use App\Core\Component\ComponentInterface;
use App\Core\Helper\ArrayHelper;
use PDO;

class Mysql implements DBAdapter, ComponentInterface
{
    private $connection;

    const DEFAULT_HOST = '127.0.0.1';

    public function __construct(array $config)
    {
        $host = ArrayHelper::getValue($config, 'host', self::DEFAULT_HOST);
        $username = ArrayHelper::getValue($config, 'username', null);
        $password = ArrayHelper::getValue($config, 'password', null);
        $dbname = ArrayHelper::getValue($config, 'dbname', null);
        $dsn = "mysql:dbname=${dbname};host=${host}";
        
        $this->connection = new \PDO($dsn, $username, $password);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
