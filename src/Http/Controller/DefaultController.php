<?php

namespace App\Http\Controller;

use App\Core\Base\Controller;
use App\Http\Service\UserService;

class DefaultController extends Controller
{
    protected $userService;

    protected $exceptAuth = [ 'login' ];

    public function __construct()
    {
        $this->userService = new UserService();
        parent::__construct();
    }

    public function actionIndex(): string
    {
        $errors = [];

        if ($this->getRequest()->isPost()) {
            $sum = (int)$this->getRequest()->post('balance');
            try {
                $this->userService->writeOff($this->currentUser, $sum);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->render('default.index', [
            'user' => $this->currentUser,
            'errors' => $errors
        ]);
    }

    public function actionLogin(): string
    {
        if (!is_null($this->currentUser)) {
            $this->redirect('/');
        }

        $errors = [];

        if ($this->getRequest()->isPost()) {
            $login = $this->getRequest()->post('login');
            $password = $this->getRequest()->post('password');
            try {
                $this->authService->login($login, $password);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            $this->redirect('/');
        }

        return $this->render('default.login', [
            'errors' => $errors
        ]);
    }

    public function actionLogout(): void
    {
        $this->authService->logout();
        $this->redirect('/default/login');
    }
}