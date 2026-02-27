<?php

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Database.php';

require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/models/Url.php';

$router = new Router();

$router->post('/api/shorten', 'HomeController@store');
$router->get('/api/stats/{code}', 'HomeController@stats');
$router->get('/{code}', 'HomeController@redirect');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/short_url/public';
$uri = str_replace($basePath, '', $uri);

if ($uri === '') {
    $uri = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);