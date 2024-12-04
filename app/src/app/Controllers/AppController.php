<?php

namespace App\Controllers;

use App\Core\Session;

class AppController
{
    public function index($queryParams)
    {
        if (Session::get('user')) {
            $user = Session::get('user');
            if ($user['role'] == 0) {
                header('Location: /customer');
            } elseif ($user['role'] == 1) {
                header('Location: /worker');
            } elseif ($user['role'] == 2) {
                header('Location: /admin');
            }
        } else {
            header('Location: /auth/login');
        }
    }
}
