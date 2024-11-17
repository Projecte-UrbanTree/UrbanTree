<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;

class CAuth implements BaseController
{
    public function get()
    {
        View::render([
            "view" => "Auth/Login",
            "title" => "Login Page",
            "layout" => "AuthLayout",
            "data" => []
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
