<?php

namespace app\core;

class View
{
    // Page title
    public string $title = 'Blog'; // Default value

    public function __construct($view, $params = [])
    {
        echo $this->renderView($view, $params);
    }

    protected function renderView(string $view, $params = [])
    {
        // Include view content
        $viewContent = $this->viewContent($view, $params);
        // Include layout content
        $layoutContent = $this->layoutContent();
        // Place view content inside layout
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/app.php";
        return ob_get_clean();
    }

    protected function viewContent($view, $params)
    {
        // We are defining params in the foreach loop below and then include the view
        // so params can be accessible inside view
        foreach ($params as $key => $value)
            $$key = $value;

        ob_start();
        include_once App::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}