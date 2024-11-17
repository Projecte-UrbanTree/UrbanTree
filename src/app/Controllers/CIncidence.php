<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MIncidence;

class CIncidence
{
    public function index()
    {
        $incidences = MIncidence::findAll();
        View::render([
            "view" => "Incidence",
            "title" => "Incidences",
            "layout" => "MainLayout",
            "data" => ["incidences" => $incidences]
        ]);
    }
}
