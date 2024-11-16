<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\PruningType;

class PruningTypeController implements BaseController
{
    public function get()
    {
        $pruning_types = PruningType::findAll();
        View::render([
            "view" => "PruningType",
            "title" => "Pruning Types",
            "layout" => "MainLayout",
            "data" => ["pruning_types" => $pruning_types]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}