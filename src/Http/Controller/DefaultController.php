<?php

namespace App\Http\Controller;

use App\Core\Base\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return 'ACTION RUN!';
    }
}