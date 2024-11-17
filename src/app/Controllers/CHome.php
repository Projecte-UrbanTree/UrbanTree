<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\MWorker;

class CHome implements BaseController
{
    public function get()
    {
        $workers = MWorker::findAll();
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
