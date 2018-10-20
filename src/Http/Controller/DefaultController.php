<?php

namespace App\Http\Controller;

use App\Core\Base\Controller;
use App\Http\Service\AuthService;
use App\Http\Service\UserService;

class DefaultController extends Controller
{
    /** @var  AuthService */
    protected $authService;

    protected $userService;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userService = new UserService();
    }

    public function actionIndex()
    {
        $user = $this->authService->getIdentity();
        $errors = [];

        if (is_null($user)) {
            $this->redirect('/default/login');
        }

        if ($this->getRequest()->isPost()) {
            $sum = (int)$this->getRequest()->post('balance');
            try {
                $this->userService->writeOff($user, $sum);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->render('default.index', [
            'user' => $user,
            'errors' => $errors
        ]);
    }

    public function actionLogin()
    {
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
}