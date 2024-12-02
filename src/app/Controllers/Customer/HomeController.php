<?php

namespace App\Controllers\Customer;

use App\Core\View;

class HomeController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Customer/Home',
            'title' => 'Map',
            'layout' => 'CustomerLayout',
        ]);
    }
}
