<?php

require_once '../app/bootstrap.php';

use App\Core\Router;

$router = new Router();
$router->load('../app/routes.php');
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);