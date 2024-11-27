<?php

use App\Controllers\AuthController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

return [
    'GET' => [
        '/auth/login' => [
            'controller' => AuthController::class,
            'method' => 'index',
            'middleware' => [GuestMiddleware::class],
        ],
        '/logout' => [
            'controller' => AuthController::class,
            'method' => 'logout',
            'middleware' => [AuthMiddleware::class],
        ],
    ],
    'POST' => [
        '/auth/login' => [
            'controller' => AuthController::class,
            'method' => 'login',
            'middleware' => [GuestMiddleware::class],
        ],
    ],
];
