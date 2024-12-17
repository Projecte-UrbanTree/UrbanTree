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
        $totalTreeTypes = TreeType::count();
        

        // Comprova si $grafiques és null i assegura't que sigui un array

        
        $contracts = Contract::findAll();

        // Renderitzem la vista amb les dades
        View::render([
            'view' => 'Admin/Grafics',
            'title' => 'Grafiques',
            'layout' => 'Admin/AdminLayout',
            'data' => ['totalContractes' => $totalContractes, 'totalTreeTypes' => $totalTreeTypes],
        ]);
    }
}
