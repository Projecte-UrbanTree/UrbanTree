<?php

// Import controller classes
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\WorkOrderController;
use App\Controllers\ZoneController;
// Import middleware classes
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

// Define routes in a grouped and structured way
return [
    'GET' => [
        // == Auth GET Routes
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
        // === App GET Routes
        '/' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        // === Users GET Routes
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
        // === WorkOrders GET Routes
        '/work-orders' => [
            'controller' => WorkOrderController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        '/work-order/create' => [
            'controller' => WorkOrderController::class,
            'method' => 'create',
            'middleware' => [AuthMiddleware::class],
        ],
        '/work-order/:id/edit' => [
            'controller' => WorkOrderController::class,
            'method' => 'edit',
            'middleware' => [AuthMiddleware::class],
        ],
        '/work-order/:id/delete' => [
            'controller' => WorkOrderController::class,
            'method' => 'destroy',
            'middleware' => [AuthMiddleware::class],
        ],
        // === Zones GET Routes
        '/zones' => [
            'controller' => ZoneController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        '/zone/create' => [
            'controller' => ZoneController::class,
            'method' => 'create',
            'middleware' => [AuthMiddleware::class],
        ],
        '/zone/:id/edit' => [
            'controller' => ZoneController::class,
            'method' => 'edit',
            'middleware' => [AuthMiddleware::class],
        ],
        '/zone/:id/delete' => [
            'controller' => ZoneController::class,
            'method' => 'destroy',
            'middleware' => [AuthMiddleware::class],
        ],
    ],
    'POST' => [
        // == Auth POST Routes
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
        // === WorkOrders POST Routes
        '/work-order/store' => [
            'controller' => WorkOrderController::class,
            'method' => 'store',
            'middleware' => [AuthMiddleware::class],
        ],
        '/work-order/:id/update' => [
            'controller' => WorkOrderController::class,
            'method' => 'update',
            'middleware' => [AuthMiddleware::class],
        ],
        // === Zones POST Routes
        '/zone/store' => [
            'controller' => ZoneController::class,
            'method' => 'store',
            'middleware' => [AuthMiddleware::class],
        ],
        '/zone/:id/update' => [
            'controller' => ZoneController::class,
            'method' => 'update',
            'middleware' => [AuthMiddleware::class],
        ],
    ],
];
