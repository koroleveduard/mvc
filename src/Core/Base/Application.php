<?php

namespace App\Core\Base;

use App\Core\Component\ComponentInterface;
use App\Core\Component\Db\DBAdapter;
use App\Core\Component\Logger\FileLogger;
use App\Core\Component\Logger\LoggerInterface;
use App\Core\Component\Logger\StdOutLogger;
use App\Core\Component\Router\RouterInterface;
use App\Core\Exception\NotFoundException;
use App\Core\Helper\ArrayHelper;

class Application extends Object
{
    protected $controllerNamespace = 'App\Http\Controller';

    protected $requestController;

    protected $requestAction;

    protected $requestParams;

    protected $components = [];

    protected $definitions = [
        'router' => [
            'className' => \App\Core\Component\Router\Router::class,
            'options' => []
        ],
        'db_driver' => [
            'className' => \App\Core\Component\Db\Mysql::class,
            'options' => []
        ],
    ];

   /** @var  LoggerInterface */
    protected $logger;

    public function getRouter(): RouterInterface
    {
        return $this->get('router');
    }

    public function getDb(): DBAdapter
    {
        return $this->get('db_driver');
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function setLoggerByConfig(array $config)
    {
        $debugMode = (boolean)ArrayHelper::getValue($config, 'debug', false);
        if ($debugMode) {
            $this->logger = new StdOutLogger();
        } else {
            $logFile = ArrayHelper::getValue($config, 'log_file', ROOT_PATH . 'log/error_log.log');
            $this->logger = new FileLogger($logFile);
        }
    }


    public function getViewPath(): string
    {
        return $this->getBasePath() . 'views';
    }

    public function getBasePath(): string
    {
        return ROOT_PATH;
    }

    public function get(string $id): ComponentInterface
    {
        if (isset($this->components[$id])) {
            return $this->components[$id];
        }

        if (isset($this->definitions[$id])) {
            $definition = $this->definitions[$id];
            if (is_array($definition) && isset($definition['className'])) {
                $class = $definition['className'];

                if (isset($definition['options'])) {
                    $object = new $class($definition['options']);
                } else {
                    $object = new $class();
                }

                return $this->components[$id] = $object;
            }
        }

        throw new NotFoundException('Component is not found');
    }
}