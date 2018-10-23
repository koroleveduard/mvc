<?php

namespace App\Core\Component\Logger;

interface LoggerInterface
{
    public function log(string $message): void;
}