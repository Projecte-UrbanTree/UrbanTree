<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MContract;

class CContract
{
    public function index()
    {
        $contracts = MContract::findAll();
        View::render([
            "view" => "Contracts",
            "title" => "Contracts",
            "layout" => "MainLayout",
            "data" => ["contracts" => $contracts]
        ]);
    }
}
