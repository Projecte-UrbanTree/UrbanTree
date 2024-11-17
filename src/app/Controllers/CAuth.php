<?php

namespace App\Controllers;

use App\Core\View;

class CAuth
{
    public function index()
    {
        View::render([
            "view" => "Auth/Login",
            "title" => "Login Page",
            "layout" => "AuthLayout",
            "data" => []
        ]);
    }
}
