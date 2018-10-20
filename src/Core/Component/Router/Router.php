<?php

namespace App\Core\Component\Router;

class Router implements RouterInterface
{
    const DEFAULT_CONTROLLER = 'default';
    const DEFAULT_ACTION = 'index';

    public function parseRequest(): array
    {
        $pathInfo = trim($_SERVER['REQUEST_URI'], '/');
        if (empty($pathInfo)) {
            return [
                self::DEFAULT_CONTROLLER,
                self::DEFAULT_ACTION,
                []
            ];
        }
        $route = null;
        if (($pos = strpos($_SERVER['REQUEST_URI'], '?')) !== false) {
            $route = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }
        $route = is_null($route) ? $_SERVER['REQUEST_URI'] : $route;
        $route = explode('/', $route);
        array_shift($route);
        $result[0] = array_shift($route);
        $result[1] = array_shift($route);
        $result[2] = $route;

        return $result;
    }
}
