<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Zone;
use App\Models\ZonePredefined;

class ZoneController
{
    public function index()
    {
        $zones = Zone::getPredefinedZonesWithElements();
        View::render([
            'view' => 'Zones',
            'title' => 'Predefined Zones',
            'layout' => 'MainLayout',
            'data' => ['zones' => $zones],
        ]);
    }

    public function create()
    {
        View::render([
            'view' => 'Zone/Create',
            'title' => 'Add Zone',
            'layout' => 'MainLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $zone = new ZonePredefined;
        $zone->name = $postData['name'];

        $zone->save();

        header('Location: /zones');
    }

    public function edit($id)
    {
        $zone = Zone::find($id);
        View::render([
            'view' => 'Zone/Edit',
            'title' => 'Edit Zone',
            'layout' => 'MainLayout',
            'data' => ['zone' => $zone],
        ]);
    }

    public function update($id, $postData)
    {
        $zone = Zone::find($id);

        $zone->predefined()->name = $postData['name'];
        $zone->predefined()->save();
        $zone->point_id = $postData['point_id'];

        $zone->save();

        header('Location: /zones');
    }

    public function destroy($id)
    {
        $zone = Zone::find($id);
        $zone->delete();

        header('Location: /zones');
    }
}
