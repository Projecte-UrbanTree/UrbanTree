<?php

use App\Controllers\AppController;

return [
    'GET' => [
        '/' => [
            'controller' => AppController::class,
            'method' => 'index',
        ],
    ],
];
