<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MPruningType;

class CPruningType
{
    public function index()
    {
        $pruning_types = MPruningType::findAll();
        View::render([
            "view" => "PruningType",
            "title" => "Pruning Types",
            "layout" => "MainLayout",
            "data" => ["pruning_types" => $pruning_types]
        ]);
    }
}
