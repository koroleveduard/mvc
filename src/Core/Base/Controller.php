<?php

namespace App\Core\Base;

class Controller
{
    const ACTION_PREFIX = 'action';

    public function runAction($action)
    {
        $actionName = self::ACTION_PREFIX.ucfirst($action);
        if (method_exists($this, $actionName)) {
            return $this->$actionName();
        }
    }
}