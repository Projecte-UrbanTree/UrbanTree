<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\MContract;

class CContract implements BaseController
{
    public function get()
    {
        $contracts = MContract::findAll();
        View::render([
            "view" => "Contracts",
            "title" => "Contracts",
            "layout" => "MainLayout",
            "data" => ["contracts" => $contracts]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
