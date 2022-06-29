<?php

namespace app\core;


use app\core\db\Database;
use app\core\db\DbModel;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'app';
    public Request $request;
    public Router $router;
    public Response $response;
    public Database $db;
    public Session $session;

    public static Application $app;
    public ?Controller $controller = null;

    public function __construct($rootDir, array $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
        $this->session = new Session();
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {

            $this->response->setStatusCode($exception->getCode());

            return new View('error', [
                'exception' => $exception,
            ]);
        }
    }

    public static function request(): Request
    {
        return self::$app->request;
    }

    public static function response(): Request
    {
        return self::$app->request;
    }
}