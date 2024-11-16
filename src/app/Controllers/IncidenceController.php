<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\Incidence;

class IncidenceController implements BaseController
{
    public function get()
    {
        $incidences = Incidence::findAll();
        View::render([
            "view" => "Incidence",
            "title" => "Incidences",
            "layout" => "MainLayout",
            "data" => ["incidences" => $incidences]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
