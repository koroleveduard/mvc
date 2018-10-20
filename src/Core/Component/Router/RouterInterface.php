<?php

namespace App\Core\Component\Router;

interface RouterInterface
{
    public function parseRequest(): array;
}