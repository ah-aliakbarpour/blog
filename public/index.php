<?php

/**
 * user: AHAAP
 * Date: 1401/4/6
 */

use app\core\App;


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


$app = new App(dirname(__DIR__), $config);


// Require routes
require_once '../routes/web.php';

$app->run();