<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Contract;
use App\Models\TreeType;
use App\Core\Controller;

class StatsController extends Controller
{
    public function index($queryParams = [])
    {
        // Obtenim les dades del model correcte
        $totalContracts = Contract::count();
        $contractsName = Contract::findAll();

        // Renderitzem la vista amb les dades
        View::render([
            'view' => 'Admin/Stats',
            'title' => 'Stats',
            'layout' => 'Admin/AdminLayout',
            'data' => ['totalContracts' => $totalContracts, 'nomsContractes' => $contractsName],
        ]);
    }

    public function grafica()
    {
        include_once __DIR__ . '/../Views/Admin/Stats/grafica.php';
    }
}
?>
