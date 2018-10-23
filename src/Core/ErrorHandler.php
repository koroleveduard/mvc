<?php

namespace App\Core;

class ErrorHandler
{

    public function init(): void
    {
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException(\Throwable $e): void
    {
        $currentDate = new \DateTime();

        Application::$app->getLogger()->log($currentDate->format('Y-m-d H:i:s') . ':' . PHP_EOL);
        Application::$app->getLogger()->log($e->getFile() . PHP_EOL);
        Application::$app->getLogger()->log($e->getMessage() . PHP_EOL);
        Application::$app->getLogger()->log($e->getTraceAsString() . PHP_EOL . PHP_EOL);
    }
}
