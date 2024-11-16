<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\Worker;

class HomeController implements BaseController
{
    public function get()
    {
        $workers = Worker::findAll();
        View::render([
            "view" => "Home",
            "title" => "Home Page",
            "layout" => "MainLayout",
            "data" => ["workers" => $workers]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
