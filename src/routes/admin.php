<?php

use App\Controllers\Admin\ContractController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ElementController;
use App\Controllers\Admin\IncidenceController;
use App\Controllers\Admin\TaskTypeController;
use App\Controllers\Admin\TreeTypeController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\WorkOrderController;
use App\Controllers\Admin\ZoneController;
use App\Middlewares\AdminMiddleware;

return [
    'GET' => [
        // === App GET Routes
        '/admin/dashboard' => [
            'controller' => DashboardController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Users GET Routes
        '/admin/users' => [
            'controller' => UserController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/user/create' => [
            'controller' => UserController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/user/:id/edit' => [
            'controller' => UserController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/user/:id/delete' => [
            'controller' => UserController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === WorkOrders GET Routes
        '/admin/work-orders' => [
            'controller' => WorkOrderController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/work-order/create' => [
            'controller' => WorkOrderController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/work-order/:id/edit' => [
            'controller' => WorkOrderController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/work-order/:id/delete' => [
            'controller' => WorkOrderController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Zones GET Routes
        '/admin/zones' => [
            'controller' => ZoneController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/zone/create' => [
            'controller' => ZoneController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/zone/:id/edit' => [
            'controller' => ZoneController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/zone/:id/delete' => [
            'controller' => ZoneController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === TreeTypes GET Routes
        '/admin/tree-types' => [
            'controller' => TreeTypeController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/tree-type/create' => [
            'controller' => TreeTypeController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/tree-type/:id/edit' => [
            'controller' => TreeTypeController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/tree-type/:id/delete' => [
            'controller' => TreeTypeController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Incidence GET Routes
        '/admin/incidence' => [
            'controller' => IncidenceController::class,
            'method' => 'index',
        ],
        '/admin/incidence/create' => [
            'controller' => IncidenceController::class,
            'method' => 'get',
        ],
        '/admin/incidence/all' => [
            'controller' => IncidenceController::class,
            'method' => 'findall',
        ],
        // === Elements GET Routes
        '/admin/elements' => [
            'controller' => ElementController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/element/create' => [
            'controller' => ElementController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/element/:id/edit' => [
            'controller' => ElementController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/element/:id/delete' => [
            'controller' => ElementController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === TaskTypes GET Routes
        '/admin/task-types' => [
            'controller' => TaskTypeController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/task-types/create' => [
            'controller' => TaskTypeController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/task-types/:id/edit' => [
            'controller' => TaskTypeController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/task-types/:id/delete' => [
            'controller' => TaskTypeController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Contracts GET Routes
        '/admin/contracts' => [
            'controller' => ContractController::class,
            'method' => 'index',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/contract/create' => [
            'controller' => ContractController::class,
            'method' => 'create',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/contract/:id/edit' => [
            'controller' => ContractController::class,
            'method' => 'edit',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/contract/:id/delete' => [
            'controller' => ContractController::class,
            'method' => 'destroy',
            'middleware' => [AdminMiddleware::class],
        ],
    ],
    'POST' => [
        '/admin/user/store' => [
            'controller' => UserController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/user/:id/update' => [
            'controller' => UserController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Elements POST Routes
        '/admin/element/store' => [
            'controller' => ElementController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/element/:id/update' => [
            'controller' => ElementController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === WorkOrders POST Routes
        '/admin/work-order/store' => [
            'controller' => WorkOrderController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/work-order/:id/update' => [
            'controller' => WorkOrderController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Zones POST Routes
        '/admin/zone/store' => [
            'controller' => ZoneController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/zone/:id/update' => [
            'controller' => ZoneController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === TreeTypes POST Routes
        '/admin/tree-type/store' => [
            'controller' => TreeTypeController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/tree-type/:id/update' => [
            'controller' => TreeTypeController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === TaskTypes POST Routes
        '/admin/task-types/store' => [
            'controller' => TaskTypeController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/task-types/:id/update' => [
            'controller' => TaskTypeController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
        // === Contracts POST Routes
        '/admin/contract/store' => [
            'controller' => ContractController::class,
            'method' => 'store',
            'middleware' => [AdminMiddleware::class],
        ],
        '/admin/contract/:id/update' => [
            'controller' => ContractController::class,
            'method' => 'update',
            'middleware' => [AdminMiddleware::class],
        ],
    ],
];
