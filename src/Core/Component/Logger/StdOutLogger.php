<?php

namespace App\Core\Component\Logger;

class StdOutLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}