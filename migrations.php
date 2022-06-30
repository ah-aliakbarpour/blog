<?php

/**
 * user: AHAAP
 * Date: 1401/4/6
 */

use app\core\App;


// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new App(__DIR__, $config);

$app->db->applyMigrations();