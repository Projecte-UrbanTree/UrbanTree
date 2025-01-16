<?php

namespace App\Controllers\Admin;

use App\Core\View;

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
