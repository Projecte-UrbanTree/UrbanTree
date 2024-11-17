<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MWorker;

class CHome
{
    public function index()
    {
        $workers = MWorker::findAll();
        View::render([
            "view" => "Home",
            "title" => "Home Page",
            "layout" => "MainLayout",
            "data" => ["workers" => $workers]
        ]);
    }
}
