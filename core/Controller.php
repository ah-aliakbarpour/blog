<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public array $middleware = [];
    public string $action = '';

    public function render(string $view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

}