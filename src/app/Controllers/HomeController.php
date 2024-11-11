<?php

namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index()
    {
        View::render([
            "view" => "Home",
            "title" => "Home Page",
            "layout" => "MainLayout",
            "data" => []
        ]);
    }
}