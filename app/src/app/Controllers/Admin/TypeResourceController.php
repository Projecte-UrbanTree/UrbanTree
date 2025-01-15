<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\TypeResource;

class TypeResourceController
{
    public function index($queryParams)
    {
        $type_resources = TypeResource::findAll();
        View::render([
            'view' => 'Admin/TypeResources',
            'title' => 'Tipos de Recursos',
            'layout' => 'Admin/AdminLayout',
            'data' => ['type_resources' => $type_resources],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TypeResource/Create',
            'title' => 'Nuevo Tipo de Recurso',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $type_resource = new TypeResource();
        $type_resource->category = $postData['category'];
        $type_resource->description = $postData['description'];
        $type_resource->save();

        if ($type_resource->getId()) {
            Session::set('success', 'Tipo de recurso creado correctamente');
        } else {
            Session::set('error', 'El tipo de recurso no se pudo crear');
        }

        header('Location: /admin/type-resources');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $type_resource = TypeResource::find($id);
        View::render([
            'view' => 'Admin/TypeResource/Edit',
            'title' => 'Editando Tipo de Recurso',
            'layout' => 'Admin/AdminLayout',
            'data' => ['type_resource' => $type_resource],
        ]);
    }

    public function update($id, $postData)
    {
        $type_resource = TypeResource::find($id);
        if ($type_resource) {
            $type_resource->category = $postData['category'];
            $type_resource->description = $postData['description'];
            $type_resource->save();

            if ($type_resource->getId()) {
                Session::set('success', 'Tipo de recurso actualizado correctamente');
            } else {
                Session::set('error', 'El tipo de recurso no se pudo actualizar');
            }
        } else {
            Session::set('error', 'El tipo de recurso no encontrado');
        }

        header('Location: /admin/type-resources');
        exit;

    }

    public function destroy($id, $queryParams)
    {
        $type_resource = TypeResource::find($id);
        if ($type_resource) {
            $type_resource->delete();
            Session::set('success', 'Tipo de recurso eliminado correctamente');
        } else {
            Session::set('error', 'El tipo de recurso no encontrado');
        }

        header('Location: /admin/type-resources');
        exit;
    }
}