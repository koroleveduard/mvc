<?php

namespace App\Http\Controller;

use App\Core\Base\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $responce = $this->render('default.index');
        return $responce;
    }

    public function actionLogin()
    {
        $responce = $this->render('default.login');
        return $responce;
    }
}