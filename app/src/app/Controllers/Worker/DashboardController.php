<?php

namespace App\Controllers\Worker;

use App\Core\View;

class DashboardController
{
    public function index($queryParams)
    {
        header('Location: /worker/work-orders');
    }
}
