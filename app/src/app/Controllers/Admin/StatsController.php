<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Contract;
use App\Models\TreeType;

class StatsController
{
    public function index($queryParams = [])
    {
        // Obtenim les dades del model correcte
        $totalContracts = Contract::count();
        $contractsName = Contract::findAll();


        // Comprova si $Stats és null i assegura't que sigui un array



        // Renderitzem la vista amb les dades
        View::render([
            'view' => 'Admin/Stats',
            'title' => 'Stats',
            'layout' => 'Admin/AdminLayout',
            'data' => ['totalContracts' => $totalContracts, 'nomsContractes' => $contractsName],
        ]);
    }
}
