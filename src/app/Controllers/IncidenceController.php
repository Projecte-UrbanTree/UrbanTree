<?php

namespace App\Controllers;

use App\Core\Session;
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

    public function create_incidence($postData)
    {

        if (empty($postData['element_id']) || empty($postData['name']) || empty($postData['description'])) {
            Session::set('error', 'Todos los campos son obligatorios');
            header('Location: /incidence/create');
            exit();
        }

        $incidence = new Incidence();
        $incidence->element_id = $postData['element_id'];
        $incidence->name = $postData['name'];
        $incidence->description = $postData['description'];

        $incidence->save();

        Session::set('success', 'Incidence created successfully');
        header('Location: /incidence');
    }
}
