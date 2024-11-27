<?php

use App\Controllers\Auth\AuthController;
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
