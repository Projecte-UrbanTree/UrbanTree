<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MElement;

class CElement
{
    public function index()
    {
        $elements = MElement::findAll();
        View::render([
            "view" => "Element",
            "title" => "Element",
            "layout" => "MainLayout",
            "data" => ["elements" => $elements]
        ]);
    }
}
