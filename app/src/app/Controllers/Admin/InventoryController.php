<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Contract;
use App\Models\Element;
use App\Models\User;
use App\Models\WorkOrder;

class InventoryController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Admin/Inventory',
            'title' => 'Inventario',
            'layout' => 'Admin/AdminInventoryLayout',
            'data' => [],
        ]);
    }
}
