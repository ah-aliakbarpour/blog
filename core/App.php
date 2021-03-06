<?php

namespace app\core;


use app\core\db\Database;
use app\core\db\DbModel;

class App
{
    public static string $ROOT_DIR;

    public Request $request;
    public Router $router;
    public Response $response;
    public Database $db;
    public Session $session;

    public static App $app;

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
            return $this->router->resolve();
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

    public static function response(): Response
    {
        return self::$app->response;
    }

    public static function session(): Session
    {
        return self::$app->session;
    }

    public static function db(): Database
    {
        return self::$app->db;
    }

}