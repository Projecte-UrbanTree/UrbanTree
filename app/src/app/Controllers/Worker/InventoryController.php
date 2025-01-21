<?php

namespace App\Controllers\Worker;

use App\Core\View;

class InventoryController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Worker/Inventory',
            'title' => 'Inventario',
            'layout' => 'Worker/WorkerInventoryLayout',
            'data' => [],
        ]);
    }
}
