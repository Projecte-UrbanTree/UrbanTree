<?php

namespace App\Controllers;


use App\Core\BaseController;
use App\Core\View;
use App\Models\Element;

class ElementController implements BaseController
{
    public function get()
    {
        $elements = Element::findAll();
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
