<?php

use App\Controllers\Api\MapController;

return [
    'GET' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'index',
        ],
        '/api/map/elementtypes' => [
            'controller' => MapController::class,
            'method' => 'getElementTypes',
        ]
    ],
    'POST' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'createZone',
        ],
        '/api/map/elements' => [
            'controller' => MapController::class,
            'method' => 'createElement',
        ]
    ],
    'DELETE' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'deleteZone',
        ]
    ],
];
