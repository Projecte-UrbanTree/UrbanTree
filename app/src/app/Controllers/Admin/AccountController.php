<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;

class AccountController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Admin/AccountConfig/AccountConfig',
            'title' => 'Configuración de cuenta',
            'layout' => 'Admin/AdminLayout',

        ]);
    }
}
