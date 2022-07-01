<?php

namespace app\core;

use app\core\exception\NotFoundException;
use app\traits\ValidatePath;
use http\Encoding\Stream\Inflate;
use const http\Client\Curl\Versions\IDN;

class Router
{
    use ValidatePath;

    protected array $routes = [];

    public function get($path, $callback)
    {
        $path = $this->validatePath($path);

        // Append to routes
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $path = $this->validatePath($path);

        // Append to routes
        $this->routes['post'][$path] = $callback;
    }

    public function getCallback(string $path, string $method)
    {
        $pathArr = explode('/', $path);

        foreach ($pathArr as &$item)
            if (is_numeric($item))
                $item = '{id}';

        $path = implode('/', $pathArr);

        // Return callback, if not exits return false
        return $this->routes[$method][$path] ?? false;
    }

    public function getIds(string $path): array
    {
        $pathArr = explode('/', $path);

        $ids = [];

        foreach ($pathArr as $item)
            if (is_numeric($item))
                $ids[] = intval($item);

        return $ids;
    }

    public function resolve()
    {
        $path = App::request()->getPath();
        $method = App::request()->method();

        $callback = $this->getCallback($path, $method);

        // This route not defined
        if ($callback === false)
            throw new NotFoundException();

        // Directly return view
        if (is_string($callback))
            return new View($callback);

        // Because of using controller, we should have an instance of controller to be able to use '$this' keyword
        // inside controller, so we create an instance
        if (is_array($callback))
        {
            $callback[0] = new $callback[0]();
            //App::$app->controller = $controller;
            //$controller->action = $callback[1];
        }

        return call_user_func($callback, $this->getIds($path)[0] ?? null);
    }
}