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

        'view' => [
            'className' => \App\Core\Component\View\View::class,
            'options' => []
        ]
    ];

    public function getRouter()
    {
        return $this->get('router');
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