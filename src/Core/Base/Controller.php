<?php

namespace App\Core\Base;

use App\Http\Entity\User;
use App\Http\Service\AuthService;

class Controller
{
    const ACTION_PREFIX = 'action';

    /** @var  View */
    protected $view;

    protected $layout = 'layout.main';

    /** @var  Request */
    protected $request;

    /** @var  AuthService */
    protected $authService;

    protected $authIsRequired = true;
    protected $exceptAuth = [];

    /** @var  User */
    protected $currentUser;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

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

    public function beforeAction(string $action): void
    {
        $this->currentUser = $this->authService->getIdentity();

        if ($this->isAuthRequired($action)) {
            if (is_null($this->currentUser)) {
                $this->redirect('/default/login');
            }
        }
    }

    private function isAuthRequired(string $action): bool
    {
        return $this->authIsRequired && !in_array($action, $this->exceptAuth);
    }

    public function runAction(string $action): string
    {
        $this->beforeAction($action);
        $actionName = self::ACTION_PREFIX.ucfirst($action);
        if (!$this->isActionExist($actionName)) {
            throw new \RuntimeException("action $action is not found!");
        }

        return $this->$actionName();
    }

    protected function isActionExist(string $name): bool
    {
        $methodExists = method_exists($this, $name);
        $methodIsNotPrivate = !(new \ReflectionMethod($this, $name))->isPrivate();

        return $methodExists && $methodIsNotPrivate;
    }

    protected function render(string $view, array $params = []): string
    {
        return $this->getView()->render($this->layout, $view, $params);
    }

    protected function redirect(string $path): void
    {
        header("location: $path");
        exit();
    }
}
