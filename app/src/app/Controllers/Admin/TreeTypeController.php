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
            'title' => 'Tipos de Árbol',
            'layout' => 'Admin/AdminLayout',
            'data' => ['tree_types' => $tree_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TreeType/Create',
            'title' => 'Nuevo Tipo de Árbol',
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
            Session::set('success', 'Tipo de árbol creado correctamente');
        else
            Session::set('error', 'El tipo de árbol no se pudo crear');

        header('Location: /admin/tree-types');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $tree_type = TreeType::find($id);

        if (!$tree_type) {
            Session::set('error', 'Tipo de árbol no encontrado');
            header('Location: /admin/tree-types');
            exit;
        }

        View::render([
            'view' => 'Admin/TreeType/Edit',
            'title' => 'Editando Tipo de Árbol',
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

            Session::set('success', 'Tipo de árbol actualizado correctamente');
        } else
            Session::set('error', 'Tipo de árbol no encontrado');

        header('Location: /admin/tree-types');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $tree_type = TreeType::find($id);

        if ($tree_type) {
            $tree_type->delete();
            Session::set('success', 'Tipo de árbol eliminado correctamente');
        } else
            Session::set('error', 'Tipo de árbol no encontrado');

        header('Location: /admin/tree-types');
        exit;
    }
}
