<?php

namespace App\Core\Base;

use App\Core\Exception\NotFoundException;
use App\Core\Application;

class View
{
    public function render(string $layout, string $view, array $params = []): string
    {
        $viewFile = $this->findViewFile($view);
        $content = $this->renderFile($viewFile, $params);
        return $this->renderContent($content, $layout);
    }

    public function findViewFile(string $view): string
    {
        $viewParts = explode('.', $view);
        $viewFile = implode(DIRECTORY_SEPARATOR, $viewParts) . '.php';
        $pathView = implode(DIRECTORY_SEPARATOR, [
            Application::$app->getViewPath(),
            $viewFile
        ]);

        if (!file_exists($pathView)) {
            throw new NotFoundException("View not found for path $pathView");
        }

        return $pathView;
    }

    public function renderContent(string $content, string $layout): string
    {
        $layoutFile = $this->findViewFile($layout);
        return $this->renderFile($layoutFile, ['content' => $content]);
    }

    public function renderFile(string $viewFile, array $params = []): string
    {
        ob_start();
        extract($params, EXTR_OVERWRITE);
        require($viewFile);
        return ob_get_clean();
    }
}