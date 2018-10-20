<?php

namespace App\Core\Base;

class Controller
{
    const ACTION_PREFIX = 'action';

    protected $view;

    protected $layout = 'layout.main';

    protected $request;


    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getView()
    {
        if ($this->view === null) {
            $this->view = new View();
        }
        return $this->view;
    }

    public function runAction($action)
    {
        $actionName = self::ACTION_PREFIX.ucfirst($action);
        if (method_exists($this, $actionName)) {
            return $this->$actionName();
        }
    }

    protected function render($view, $params = [])
    {
        return $this->getView()->render($this->layout, $view, $params);
    }

    protected function redirect($path)
    {
        header("location: $path");
        exit();
    }
}
