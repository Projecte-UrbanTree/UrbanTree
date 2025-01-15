<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\TreeType;

class TreeTypeController
{
    public function index($queryParams)
    {
        $tree_types = TreeType::findAll();
        View::render([
            'view' => 'Admin/TreeTypes',
            'title' => 'Especies',
            'layout' => 'Admin/AdminLayout',
            'data' => ['tree_types' => $tree_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TreeType/Create',
            'title' => 'Nueva Especie',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $tree_type = new TreeType();
        $tree_type->family = $postData['family'];
        $tree_type->genus = $postData['genus'];
        $tree_type->species = $postData['species'];

        $tree_type->save();

        if ($tree_type->getId())
            Session::set('success', 'Especie creada correctamente');
        else
            Session::set('error', 'La especie no se pudo crear');

        header('Location: /admin/tree-types');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $tree_type = TreeType::find($id);

        if (!$tree_type) {
            Session::set('error', 'Especie no encontrada');
            header('Location: /admin/tree-types');
            exit;
        }

        View::render([
            'view' => 'Admin/TreeType/Edit',
            'title' => 'Editando Especie',
            'layout' => 'Admin/AdminLayout',
            'data' => ['tree_type' => $tree_type],
        ]);
    }

    public function update($id, $postData)
    {
        $tree_type = TreeType::find($id);

        if ($tree_type) {
            $tree_type->family = $postData['family'];
            $tree_type->genus = $postData['genus'];
            $tree_type->species = $postData['species'];

            $tree_type->save();

            Session::set('success', 'Especie actualizada correctamente');
        } else
            Session::set('error', 'Especie no encontrada');

        header('Location: /admin/tree-types');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $tree_type = TreeType::find($id);

        if ($tree_type) {
            $tree_type->delete();
            Session::set('success', 'Especie eliminada correctamente');
        } else
            Session::set('error', 'Especie no encontrada');

        header('Location: /admin/tree-types');
        exit;
    }
}
