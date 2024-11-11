<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Element;

class ElementController
{
    public function index()
    {
        $elements = Element::getAll();
        View::render([
            "view" => "Element",
            "title" => "Element",
            "layout" => "MainLayout",
            "data" => ["elements" => $elements]
        ]);
    }
}