<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\MIncidence;

class CIncidence implements BaseController
{
    public function get()
    {
        $incidences = MIncidence::findAll();
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
