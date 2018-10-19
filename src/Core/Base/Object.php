<?php

namespace App\Core\Base;

class Object
{
    public function __get($name)
    {
        $getter = 'get' . $name;

        if (!method_exists($this, $getter)) {
            throw new \RuntimeException("Method $name is not found!");
        }

        return $this->$getter();
    }
}
