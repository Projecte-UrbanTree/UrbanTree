<?php

use App\Controllers\AppController;

return [
    'GET' => [
        '/' => [
            'controller' => AppController::class,
            'method' => 'index',
        ],
        '/privacy-policy' => [
            'controller' => AppController::class,
            'method' => 'privacyPolicy',
        ],
        '/cookie-policy' => [
            'controller' => AppController::class,
            'method' => 'cookiePolicy',
        ],
        '/terms-and-conditions' => [
            'controller' => AppController::class,
            'method' => 'termsConditions',
        ],
    ],
];
