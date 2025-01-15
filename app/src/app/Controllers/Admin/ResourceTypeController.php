<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\ResourceType;

class ResourceTypeController
{
    public function index($queryParams)
    {
        $resource_types = ResourceType::findAll();
        View::render([
            'view' => 'Admin/ResourceTypes',
            'title' => 'Tipos de Recursos',
            'layout' => 'Admin/AdminLayout',
            'data' => ['resource_types' => $resource_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/ResourceType/Create',
            'title' => 'Nuevo Tipo de Recurso',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $resource_type = new ResourceType();
        $resource_type->name = $postData['name'];
        $resource_type->description = $postData['description'];
        $resource_type->save();

        if ($resource_type->getId()) {
            Session::set('success', 'Tipo de recurso creado correctamente');
        } else {
            Session::set('error', 'El tipo de recurso no se pudo crear');
        }

        header('Location: /admin/resource-types');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $resource_type = ResourceType::find($id);
        View::render([
            'view' => 'Admin/ResourceType/Edit',
            'title' => 'Editando Tipo de Recurso',
            'layout' => 'Admin/AdminLayout',
            'data' => ['resource_type' => $resource_type],
        ]);
    }

    public function update($id, $postData)
    {
        $resource_type = ResourceType::find($id);
        if ($resource_type) {
            $resource_type->name = $postData['name'];
            $resource_type->description = $postData['description'];
            $resource_type->save();

            if ($resource_type->getId()) {
                Session::set('success', 'Tipo de recurso actualizado correctamente');
            } else {
                Session::set('error', 'El tipo de recurso no se pudo actualizar');
            }
        } else {
            Session::set('error', 'Tipo de recurso no encontrado');
        }

        header('Location: /admin/resource-types');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $resource_type = ResourceType::find($id);
        if ($resource_type) {
            $resource_type->delete();
            Session::set('success', 'Tipo de recurso eliminado correctamente');
        } else {
            Session::set('error', 'Tipo de recurso no encontrado');
        }

        header('Location: /admin/resource-types');
        exit;
    }
}
