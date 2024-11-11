<?php

require_once '../bootstrap/app.php';

use App\Core\Router;

$router = new Router();
$router->load('../routes/web.php');
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);