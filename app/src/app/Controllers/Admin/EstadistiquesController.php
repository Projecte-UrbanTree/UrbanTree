<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Contract;
use App\Models\TreeType;

class EstadistiquesController
{
    public function index($queryParams = [])
    {
        // Obtenim les dades del model correcte
        $totalContractes = Contract::count();
        $nomcontracts = Contract::findAll();
        

        // Comprova si $grafiques és null i assegura't que sigui un array

        

        // Renderitzem la vista amb les dades
        View::render([
            'view' => 'Admin/Grafics',
            'title' => 'Grafiques',
            'layout' => 'Admin/AdminLayout',
            'data' => ['totalContractes' => $totalContractes, 'nomsContractes' => $nomcontracts],
        ]);
    }
}
