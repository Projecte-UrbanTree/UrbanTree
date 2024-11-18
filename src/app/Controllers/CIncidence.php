<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MIncidence;
use App\Models\MElement;

class CIncidence
{
    public function index()
    {
        View::render([
            "view" => "Incidence",
            "title" => "Incidences",
            "layout" => "MainLayout",
        ]);
    }

    public function findall()
    {
        $incidences = MIncidence::findAll();

        View::render([
            "view" => "Incidence/SeeAllIncidences",
            "title" => "Incidences",
            "layout" => "MainLayout",
            "data" => ["incidences" => $incidences]
        ]);
    }

    public function get()
    {
        $elements = MElement::findAll();

        View::render([
            "view" => "Incidence/Create",
            "title" => "Create Incidence",
            "layout" => "MainLayout",
            "data" => [
                "elements" => $elements,
            ]
        ]);
    }
}
