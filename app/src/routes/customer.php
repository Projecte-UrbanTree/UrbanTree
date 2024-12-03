<?php

use App\Controllers\Customer\HomeController;
use App\Middlewares\CustomerMiddleware;

return [
    'GET' => [
        '/customer' => [
            'controller' => HomeController::class,
            'method' => 'index',
            'middlewares' => [CustomerMiddleware::class],
        ],
    ],
];
