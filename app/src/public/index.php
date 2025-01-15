<?php

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/bootstrap.php';

use App\Core\Router;

$router = new Router;

$router->loadDir('../routes');

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_POST);
