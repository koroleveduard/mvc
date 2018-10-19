<?php

namespace App\Core\Base;

use App\Core\Exception\NotFoundException;
use App\Core\Application;

class View
{
    public function render($layout, $view, $params = [])
    {
        $viewFile = $this->findViewFile($view);
        $content = $this->renderFile($viewFile, $params);
        return $this->renderContent($content, $layout);
    }

    public function findViewFile($view)
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

    public function renderContent($content, $layout)
    {
        $layoutFile = $this->findViewFile($layout);
        return $this->renderFile($layoutFile, ['content' => $content]);
    }

    public function renderFile($viewFile, $params)
    {
        ob_start();
        extract($params, EXTR_OVERWRITE);
        require($viewFile);
        return ob_get_clean();
    }
}