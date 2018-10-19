<?php

namespace App\Core\Base;

class Controller
{
    const ACTION_PREFIX = 'action';

    protected $view;

    protected $layout = 'layout.main';

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

    public function render($view, $params = [])
    {
        return $this->getView()->render($this->layout, $view, $params);
    }
}
