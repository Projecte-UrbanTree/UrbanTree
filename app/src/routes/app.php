<?php

use App\Controllers\AppController;

return [
    'GET' => [
        '/' => [
            'controller' => AppController::class,
            'method' => 'index',
        ],
        '/cookie-policy' => [
            'controller' => AppController::class,
            'method' => 'cookiePolicy',
        ],
    ],
];
