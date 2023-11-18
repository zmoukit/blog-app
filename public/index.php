<?php

use Controllers\Auth\AuthController;
use Controllers\HomeController;
use Core\Application;

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


// config
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

// Init application
$app = new Application(dirname(__DIR__), $config);

// Declare application's routes
$router = $app->getRouter();
$router->get('/', [new HomeController(), 'home']);

// auth routes
$router->get('/register', [new AuthController('auth'), 'register']);
$router->post('/register', [new AuthController('auth'), 'register']);

$router->get('/login', [new AuthController('auth'), 'login']);
$router->post('/login', [new AuthController('auth'), 'login']);

$router->get('/logout', [new AuthController('auth'), 'logout']);

// posts routes
$router->get('/posts', 'posts/list');

// run the application
$app->run();
