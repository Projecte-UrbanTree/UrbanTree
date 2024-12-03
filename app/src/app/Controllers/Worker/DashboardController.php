<?php

namespace App\Controllers\Worker;

use App\Core\View;

class DashboardController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Worker/Dashboard',
            'title' => 'Worker Dashboard',
            'layout' => 'Worker/WorkerLayout',
        ]);
    }
}
