<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Element;
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

    public function findall()
    {
        $incidences = Incidence::findAll();
        View::render([
            'view' => 'Incidence/SeeAllIncidences',
            'title' => 'Incidences',
            'layout' => 'MainLayout',
            'data' => ['incidences' => $incidences],
        ]);
    }

    public function get()
    {
        $elements = Element::findAll();

        View::render([
            'view' => 'Incidence/Create',
            'title' => 'Create Incidence',
            'layout' => 'MainLayout',
            'data' => [
                'elements' => $elements,
            ],
        ]);
    }
}
