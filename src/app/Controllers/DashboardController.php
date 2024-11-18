<?php

namespace App\Controllers;

use App\Core\View;

class DashboardController
{
    public function index()
    {
        View::render([
            'view' => 'Dashboard',
            'title' => 'Dashboard',
            'layout' => 'MainLayout',
            'data' => [],
        ]);
    }
}
