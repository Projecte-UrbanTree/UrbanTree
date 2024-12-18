<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Zone;

class ZoneController
{
    public function index($queryParams)
    {
        $zones = Zone::findAll(['name' => 'not null']);
        View::render([
            'view' => 'Admin/Zones',
            'title' => 'Zonas',
            'layout' => 'Admin/AdminLayout',
            'data' => ['zones' => $zones],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/Zone/Create',
            'title' => 'Nueva Zona',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $zone = new Zone();
        $zone->name = $postData['name'];

        $zone->save();

        if ($zone->getId())
            Session::set('success', 'Zona creada correctamente');
        else
            Session::set('error', 'La zona no se pudo crear');

        header('Location: /admin/zones');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $zone = Zone::find($id);

        if (!$zone) {
            Session::set('error', 'Zona no encontrada');
            header('Location: /admin/zones');
            exit;
        }

        View::render([
            'view' => 'Admin/Zone/Edit',
            'title' => 'Editando Zona',
            'layout' => 'Admin/AdminLayout',
            'data' => ['zone' => $zone],
        ]);
    }

    public function update($id, $postData)
    {
        $zone = Zone::find($id);
        if ($zone) {
            $zone->contract_id = $postData['contract_id'];
            $zone->name = $postData['name'];

            $zone->save();

            Session::set('success', 'Zona actualizada correctamente');
        } else
            Session::set('error', 'Zona no encontrada');

        header('Location: /admin/zones');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $zone = Zone::find($id);

        if ($zone) {
            $zone->delete();
            Session::set('success', 'Zona eliminada correctamente');
        } else
            Session::set('error', 'Zona no encontrada');

        header('Location: /admin/zones');
        exit;
    }
}
