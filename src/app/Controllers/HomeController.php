<?php

namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Home',
            'title' => 'Map',
            'layout' => 'MapLayout',
        ]);
    }
}
