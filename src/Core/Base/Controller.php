<?php

namespace App\Core\Base;

class Controller
{
    const ACTION_PREFIX = 'action';

    /** @var  View */
    protected $view;

    protected $layout = 'layout.main';

    /** @var  Request */
    protected $request;

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getView(): View
    {
        if ($this->view === null) {
            $this->view = new View();
        }
        return $this->view;
    }

    public function runAction($action)
    {
        $actionName = self::ACTION_PREFIX.ucfirst($action);
        if (!method_exists($this, $actionName)) {
            throw new \RuntimeException("action $action is not found!");
        }

        return $this->$actionName();
    }

    protected function render(string $view, array $params = [])
    {
        return $this->getView()->render($this->layout, $view, $params);
    }

    protected function redirect(string $path)
    {
        header("location: $path");
        exit();
    }
}
