<?php

namespace App\Core;

use App\Core\Helper\ArrayHelper;
use App\Core\Base\Application as BaseApplication;

class Application extends BaseApplication
{
    public static $app = null;

    public function __construct()
    {
        static::$app = $this;
    }

    public function run(array $config = [])
    {
        $this->init($config);
        $this->handleRequest();
    }

    private function init($config)
    {
        $components = ArrayHelper::getValue($config, 'components', []);
        $this->definitions = array_merge($this->definitions, $components);
    }

    public function handleRequest()
    {
        $result = $this->getRouter()->parseRequest();

        list($this->requestController,$this->requestAction,$this->requestParams) = $result;
        $controllerInstance = $this->createController($this->requestController);
        $responce = $controllerInstance->runAction($this->requestAction);

        echo $responce;
    }

    public function createController($controller)
    {
        $controllerName = ucfirst($controller).'Controller';
        $controllerClassName = $this->controllerNamespace.'\\'.$controllerName;
        return new $controllerClassName();
    }
}