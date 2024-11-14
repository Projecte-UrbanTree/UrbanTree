<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\TreeType;

class TreeTypesController
{
    public function index()
    {
        $tree_types = TreeType::getAll();
        View::render([
            "view" => "TreeTypes",
            "title" => "Tree Types",
            "layout" => "MainLayout",
            "data" => ["tree_types" => $tree_types]
        ]);
    }
}