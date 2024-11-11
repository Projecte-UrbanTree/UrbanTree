<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Worker;

class HomeController
{
    public function index()
    {
        $workers = Worker::getAll();
        View::render([
            "view" => "Home",
            "title" => "Home Page",
            "layout" => "MainLayout",
            "data" => ["workers" => $workers]
        ]);
    }
}