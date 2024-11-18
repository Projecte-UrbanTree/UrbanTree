<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\IncidenceController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

// Define routes in a grouped and structured way
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
        '/' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        '/users' => [
            'controller' => UserController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        '/user/create' => [
            'controller' => UserController::class,
            'method' => 'create',
            'middleware' => [AuthMiddleware::class],
        ],
        '/user/:id/edit' => [
            'controller' => UserController::class,
            'method' => 'edit',
            'middleware' => [AuthMiddleware::class],
        ],
        '/user/:id/delete' => [
            'controller' => UserController::class,
            'method' => 'destroy',
            'middleware' => [AuthMiddleware::class],
        ],
        '/incidence' => [
            "controller" => IncidenceController::class,
            "method"=> "index"
        ],
        "/incidence/create" => [
            "controller" => IncidenceController::class,
            "method"=> "get"
        ],
        "/incidence/all" => [
            "controller" => IncidenceController::class,
            "method"=> "findall"
        ]

    ],
    'POST' => [
        '/auth/login' => [
            'controller' => AuthController::class,
            'method' => 'login',
            'middleware' => [GuestMiddleware::class],
        ],
        '/user/store' => [
            'controller' => UserController::class,
            'method' => 'store',
            'middleware' => [AuthMiddleware::class],
        ],
        '/user/:id/update' => [
            'controller' => UserController::class,
            'method' => 'update',
            'middleware' => [AuthMiddleware::class],
        ],
    ],
];
