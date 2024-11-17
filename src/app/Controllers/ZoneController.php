<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Zone;

class ZoneController
{
    public function index()
    {
        $zones = Zone::findAll();
        View::render([
            "view" => "Zone",
            "title" => "Zones",
            "layout" => "MainLayout",
            "data" => ["zones" => $zones]
        ]);
    }
}
