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
        '/api/map/elements/:id' => [
            'controller' => MapController::class,
            'method' => 'getElement',
        ],
        '/api/map/elements/:id/incidences' => [
            'controller' => MapController::class,
            'method' => 'getIncidences',
        ],
        '/api/map/elements/:id/history' => [
            'controller' => MapController::class,
            'method' => 'getElementHistory',
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
        '/api/map/elements/:id/incidences' => [
            'controller' => MapController::class,
            'method' => 'createIncidence',
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
        '/api/map/elements/description' => [
            'controller' => MapController::class,
            'method' => 'updateElementDescription',
        ],
        '/api/map/zones/description' => [
            'controller' => MapController::class,
            'method' => 'updateZoneDescription',
        ],
        '/api/map/incidences/:id/status' => [
            'controller' => MapController::class,
            'method' => 'toggleIncidenceStatus',
        ],
    ],
    'DELETE' => [
        '/api/map/zones' => [
            'controller' => MapController::class,
            'method' => 'deleteZone',
        ],
        '/api/map/elements' => [
            'controller' => MapController::class,
            'method' => 'deleteElement',
        ],
        '/api/map/incidences/:id' => [
            'controller' => MapController::class,
            'method' => 'deleteIncidence',
        ],
    ],
];
