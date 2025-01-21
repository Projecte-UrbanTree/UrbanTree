<?php

namespace App\Controllers\Customer;

use App\Core\View;

class DashboardController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Customer/Dashboard',
            'title' => 'Map',
            'layout' => 'Customer/CustomerInventoryLayout',
        ]);
    }
}
