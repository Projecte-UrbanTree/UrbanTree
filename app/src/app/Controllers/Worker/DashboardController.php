<?php

namespace App\Controllers\Worker;

class DashboardController
{
    public function index($queryParams)
    {
        header('Location: /worker/work-orders');
    }
}
