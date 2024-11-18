<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Incidence;

class IncidenceController
{
    public function index()
    {
        View::render([
            'view' => 'Incidence',
            'title' => 'Incidences',
            'layout' => 'MainLayout',
        ]);
    }

    public function findAll()
    {
        $incidences = Incidence::findAll();

        View::render([
            'view' => 'Incidence/SeeAllIncidences',
            'title' => 'Incidences',
            'layout' => 'MainLayout',
            'data' => ['incidences' => $incidences],
        ]);
    }
}
