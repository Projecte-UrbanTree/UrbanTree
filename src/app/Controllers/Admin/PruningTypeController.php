<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\PruningType;

class PruningTypeController
{
    public function index($queryParams)
    {
        $pruning_types = PruningType::findAll();
        View::render([
            'view' => 'Admin/PruningType',
            'title' => 'Pruning Types',
            'layout' => 'Admin/AdminLayout',
            'data' => ['pruning_types' => $pruning_types],
        ]);
    }
}
