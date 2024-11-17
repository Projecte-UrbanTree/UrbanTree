<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\MZone;

class CZone implements BaseController
{
    public function get()
    {
        $zones = MZone::findAll();
        View::render([
            "view" => "Zone",
            "title" => "Zones",
            "layout" => "MainLayout",
            "data" => ["zones" => $zones]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
