<?php

use App\Controllers\Customer\DashboardController;
use App\Middlewares\CustomerMiddleware;

return [
    'GET' => [
        '/customer' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middlewares' => [CustomerMiddleware::class],
        ],
    ],
];
