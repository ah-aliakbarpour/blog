<?php

/**
 * @var $app
 */

use app\controllers\BlogController;
use app\core\View;


$app->router->get('/', function () {
    return new View('home');
});

$app->router->get('/blog', [BlogController::class, 'index']);
$app->router->get('/blog/{id}', [BlogController::class, 'show']);
$app->router->get('/blog/create',  [BlogController::class, 'create']);
$app->router->post('/blog/create',  [BlogController::class, 'save']);
$app->router->get('/blog/{id}/edit',  [BlogController::class, 'edit']);
$app->router->post('/blog/{id}/edit',  [BlogController::class, 'update']);
$app->router->post('/blog/{id}/destroy',  [BlogController::class, 'destroy']);