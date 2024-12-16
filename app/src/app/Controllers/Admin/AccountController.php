<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\User;

class AccountController
{
    public function index($queryParams)
    {   

        $user = User::find(Session::get('user')['id']);
        View::render([
            'view' => 'Admin/AccountConfig/AccountConfig',
            'title' => 'Configuración de cuenta',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
