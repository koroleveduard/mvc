<?php

namespace App\Core\Base;

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

    public function getRouter()
    {
        return $this->get('router');
    }

    public function getDb()
    {
        return $this->get('db_driver');
    }

    public function getViewPath()
    {
        return $this->getBasePath() . 'views';
    }

    public function getBasePath()
    {
        return ROOT_PATH;
    }

    public function get($id)
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
    }
}