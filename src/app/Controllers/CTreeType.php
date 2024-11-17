<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MTreeType;

class CTreeType
{
    public function index()
    {
        $tree_types = MTreeType::findAll();
        View::render([
            "view" => "TreeType",
            "title" => "Tree Types",
            "layout" => "MainLayout",
            "data" => ["tree_types" => $tree_types]
        ]);
    }
}
