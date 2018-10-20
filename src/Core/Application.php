<?php

namespace App\Core;

use App\Core\Base\Controller;
use App\Core\Base\Request;
use App\Core\Exception\NotFoundException;
use App\Core\Helper\ArrayHelper;
use App\Core\Base\Application as BaseApplication;

class Application extends BaseApplication
{
    public static $app = null;

    public function __construct()
    {
        static::$app = $this;
    }

    public function run(array $config = []): void
    {
        $this->init($config);
        $this->handleRequest();
    }

    private function init(array $config): void
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

    public function createController(string $controller): Controller
    {
        $request = Request::createFromGlobals();
        $controllerName = ucfirst($controller).'Controller';
        $controllerClassName = $this->controllerNamespace.'\\'.$controllerName;

        if (!class_exists($controllerClassName)) {
            throw new NotFoundException("Controller $controllerClassName is not found!");
        }

        /** @var Controller $instanceController */
        $instanceController = new $controllerClassName();
        $instanceController->setRequest($request);

        return $instanceController;
    }
}
