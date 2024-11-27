<?php

use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Middlewares\AdminMiddleware;

return [
    'GET' => [
        '/' => [
            'controller' => HomeController::class,
            'method' => 'index',
        ],
        '/dashboard' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
    ],
];
