<?php

namespace App\Core\Base;

class Request
{
    protected $method;
    protected $getParams;
    protected $postParams;

    public function __construct($method, $getParams, $postParams)
    {
        $this->method = $method;
        $this->getParams = $getParams;
        $this->postParams = $postParams;
    }

    public static function createFromGlobals()
    {
        return new self(
            $_SERVER['REQUEST_METHOD'],
            $_GET,
            $_POST
        );
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function post($key, $default = null)
    {
        if (isset($this->postParams[$key])) {
            return $this->postParams[$key];
        }

        return $default;
    }
}