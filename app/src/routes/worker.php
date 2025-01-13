<?php

use App\Controllers\Worker\DashboardController;
use App\Controllers\Worker\WorkOrderController;
use App\Middlewares\WorkerMiddleware;

return [
    'GET' => [
        '/worker' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middlewares' => [WorkerMiddleware::class],
        ],
        '/worker/work-orders' => [
            'controller' => WorkOrderController::class,
            'method' => 'index',
            'middlewares' => [WorkerMiddleware::class],
        ],
    ],
    'POST' => [
        '/worker/work-orders/update-status' => [
            'controller' => WorkOrderController::class,
            'method' => 'updateStatus',
            'middlewares' => [WorkerMiddleware::class],
        ],
    ],
];
