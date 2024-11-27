<?php

use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Middlewares\WorkerMiddleware;

return [
    'GET' => [
        '/' => [
            'controller' => HomeController::class,
            'method' => 'index',
        ],
        '/dashboard' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middlewares' => [WorkerMiddleware::class],
        ],
    ],
];
