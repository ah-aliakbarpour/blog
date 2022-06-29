<?php

/**
 * user: AHAAP
 * Date: 1401/4/6
 */

use app\controllers\AuthController;
use app\controllers\BlogController;
use app\controllers\SiteController;
use app\core\Application;
use app\models\User;


//echo '<pre>';
//var_dump(implode('/', [1, 2, 3]));
//echo '</pre>';
//
//
//exit();


// Require composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];


$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', function () {
    return 'Home';
});


$app->router->get('/blog', [BlogController::class, 'index']);
$app->router->get('/blog/{id}', [BlogController::class, 'show']);
$app->router->get('/blog/create',  [BlogController::class, 'create']);
$app->router->post('/blog/create',  [BlogController::class, 'save']);
$app->router->get('/blog/{id}/edit',  [BlogController::class, 'edit']);
$app->router->post('/blog/{id}/edit',  [BlogController::class, 'update']);
$app->router->post('/blog/{id}/destroy',  [BlogController::class, 'destroy']);


$app->run();