<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Element;
use App\Models\Incidence;

class IncidenceController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Admin/Incidence',
            'title' => 'Incidences',
            'layout' => 'AdminLayout',
        ]);
    }

    public function findall($queryParams)
    {
        $incidences = Incidence::findAll();
        View::render([
            'view' => 'Admin/Incidence/SeeAllIncidences',
            'title' => 'Incidences',
            'layout' => 'AdminLayout',
            'data' => ['incidences' => $incidences],
        ]);
    }

    public function get($queryParams)
    {
        $elements = Element::findAll();

        View::render([
            'view' => 'Admin/Incidence/Create',
            'title' => 'Create Incidence',
            'layout' => 'AdminLayout',
            'data' => [
                'elements' => $elements,
            ],
        ]);
    }
}
