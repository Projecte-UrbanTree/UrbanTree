<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\TreeType;

class TreeTypeController implements BaseController
{
    public function get()
    {
        $tree_types = TreeType::findAll();
        View::render([
            "view" => "TreeType",
            "title" => "Tree Types",
            "layout" => "MainLayout",
            "data" => ["tree_types" => $tree_types]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}