<?php

// Import controller classes
use App\Controllers\AuthController;
use App\Controllers\ContractController;
use App\Controllers\DashboardController;
use App\Controllers\ElementController;
use App\Controllers\IncidenceController;
use App\Controllers\TreeTypeController;
use App\Controllers\UserController;
use App\Controllers\WorkOrderController;
use App\Controllers\ZoneController;
use App\Controllers\TaskTypeController;
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
        // === TreeTypes GET Routes
        '/tree-types' => [
            'controller' => TreeTypeController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        // === Incidence GET Routes
        '/incidence' => [
            'controller' => IncidenceController::class,
            'method' => 'index',
        ],
        '/incidence/create' => [
            'controller' => IncidenceController::class,
            'method' => 'get',
        ],
        '/incidence/all' => [
            'controller' => IncidenceController::class,
            'method' => 'findall',
        ],
        // === Elements GET Routes
        '/elements' => [
            'controller' => ElementController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        // === TaskTypes GET Routes
        '/task-types' => [
            'controller' => TaskTypeController::class,
            'method' => 'index',
            'middleware' => [AuthMiddleware::class],
        ],
        '/task-types/create' => [
            'controller' => TaskTypeController::class,
            'method' => 'create',
            'middleware' => [AuthMiddleware::class],
        ],
        '/task-types/:id/edit' => [
            'controller' => TaskTypeController::class,
            'method' => 'edit',
            'middleware' => [AuthMiddleware::class],
        ],
        '/task-types/:id/delete' => [
            'controller' => TaskTypeController::class,
            'method' => 'destroy',
            'middleware' => [AuthMiddleware::class],
        ],
        // === Contracts GET Routes
        '/contracts' => [
            'controller' => ContractController::class,
            'method' => 'index',
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
        // === TaskTypes POST Routes
        '/task-types/store' => [
            'controller' => TaskTypeController::class,
            'method' => 'store',
            'middleware' => [AuthMiddleware::class],
        ],
        '/task-types/:id/update' => [
            'controller' => TaskTypeController::class,
            'method' => 'update',
            'middleware' => [AuthMiddleware::class],
        ],
    ],
];
