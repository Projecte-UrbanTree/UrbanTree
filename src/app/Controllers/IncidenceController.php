<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Incidence;

class IncidenceController
{
    public function index()
    {
        $incidences = Incidence::findAll();
        View::render([
            "view" => "Incidence",
            "title" => "Incidences",
            "layout" => "MainLayout",
            "data" => ["incidences" => $incidences]
        ]);
    }
}
