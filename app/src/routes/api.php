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
        ],
        '/api/map/treetypes' => [
            'controller' => MapController::class,
            'method' => 'getTreeTypes',
        ],
    ],
    'POST' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'createZone',
        ],
        '/api/map/elements' => [
            'controller' => MapController::class,
            'method' => 'createElement',
        ],
    ],
    'PUT' => [
        '/api/map/zones/name' => [
            'controller' => MapController::class,
            'method' => 'updateZoneName',
        ],
        '/api/map/zones/color' => [
            'controller' => MapController::class,
            'method' => 'updateZoneColor',
        ],
    ],
    'DELETE' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'deleteZone',
        ],
    ],
];
