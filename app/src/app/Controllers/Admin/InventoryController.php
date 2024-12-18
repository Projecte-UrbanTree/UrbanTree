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
        $users = User::count();
        $contracts = Contract::count();
        $elements = Element::count();
        $workorders = WorkOrder::count();
        View::render([
            'view' => 'Admin/Inventory',
            'title' => 'Tablero',
            'layout' => 'Admin/AdminInventoryLayout',
            'data' => [
                'users' => $users,
                'contracts' => $contracts,
                'elements' => $elements,
                'workorders' => $workorders,
            ],
        ]);
    }
}
