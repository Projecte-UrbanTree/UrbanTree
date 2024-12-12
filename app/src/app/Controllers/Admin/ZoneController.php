<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Zone;

class ZoneController
{
    public function index($queryParams)
    {
        $zones = Zone::findAll(['name' => 'not null']);
        View::render([
            'view' => 'Admin/Zones',
            'title' => 'Predefined Zones',
            'layout' => 'Admin/AdminLayout',
            'data' => ['zones' => $zones],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/Zone/Create',
            'title' => 'Add Zone',
            'layout' => 'Admin/AdminLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $zone = new Zone();
        $zone->name = $postData['name'];

        $zone->save();

        header('Location: /admin/zones');
    }

    public function edit($id, $queryParams)
    {
        $zone = Zone::find($id);
        View::render([
            'view' => 'Admin/Zone/Edit',
            'title' => 'Edit Zone',
            'layout' => 'Admin/AdminLayout',
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

        header('Location: /admin/zones');
    }

    public function destroy($id, $queryParams)
    {
        $zone = Zone::find($id);
        $zone->delete();

        header('Location: /admin/zones');
    }
}
