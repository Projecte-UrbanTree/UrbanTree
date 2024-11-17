<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\MElement;

class CElement implements BaseController
{
    public function get()
    {
        $elements = MElement::findAll();
        View::render([
            "view" => "Element",
            "title" => "Element",
            "layout" => "MainLayout",
            "data" => ["elements" => $elements]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
