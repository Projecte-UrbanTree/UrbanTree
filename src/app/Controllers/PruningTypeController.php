<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\PruningType;

class PruningTypeController
{
    public function index()
    {
        $pruning_types = PruningType::findAll();
        View::render([
            'view' => 'PruningType',
            'title' => 'Pruning Types',
            'layout' => 'MainLayout',
            'data' => ['pruning_types' => $pruning_types],
        ]);
    }
}
