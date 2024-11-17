<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MZone;

class CZone
{
    public function index()
    {
        $zones = MZone::findAll();
        View::render([
            "view" => "Zone",
            "title" => "Zones",
            "layout" => "MainLayout",
            "data" => ["zones" => $zones]
        ]);
    }
}
