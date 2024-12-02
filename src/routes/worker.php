<?php

use App\Controllers\Worker\DashboardController;
use App\Middlewares\WorkerMiddleware;

return [
    'GET' => [
        '/worker' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middlewares' => [WorkerMiddleware::class],
        ],
    ],
];
