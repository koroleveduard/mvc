<?php

namespace App\Core\Component\Logger;

class FileLogger implements LoggerInterface
{
    protected $file;

    public function __construct($file = null)
    {
        $this->file = $file;
    }

    public function log(string $message): void
    {
        file_put_contents($this->file, $message, FILE_APPEND);
    }

}