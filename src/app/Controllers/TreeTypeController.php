<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\TreeType;

class TreeTypeController
{
    public function index()
    {
        $tree_types = TreeType::getAll();
        View::render([
            "view" => "TreeType",
            "title" => "Tree Types",
            "layout" => "MainLayout",
            "data" => ["tree_types" => $tree_types]
        ]);
    }
}