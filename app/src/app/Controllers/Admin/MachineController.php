<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Machine;

class MachineController {
    public function index(){
        $machines = Machine::findAll();

        View::render([
            'view' => 'Admin/Machines',
            'title' => 'Máquinas',
            'layout' => 'Admin/AdminLayout',
            'data' => ['machines' => $machines],
        ]);
    }
}