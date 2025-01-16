<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\ElementType;

class ElementTypeController
{
    public function index($queryParams)
    {
        $element_types = ElementType::findAll();
        View::render([
            'view' => 'Admin/ElementTypes',
            'title' => 'Tipos de Elemento',
            'layout' => 'Admin/AdminLayout',
            'data' => ['element_types' => $element_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/ElementType/Create',
            'title' => 'Nuevo Tipo de Elemento',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $element_type = new ElementType;
        $element_type->name = $postData['name'];
        $element_type->description = $postData['description'];
        $element_type->icon = $postData['icon'];
        $element_type->color = $postData['color'];

        $element_type->save();

        if ($element_type->getId()) {
            Session::set('success', 'Tipo de elemento creado correctamente');
        } else {
            Session::set('error', 'El tipo de elemento no se pudo crear');
        }

        header('Location: /admin/element-types');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $element_type = ElementType::find($id);

        if (! $element_type) {
            Session::set('error', 'Tipo de elemento no encontrado');
            header('Location: /admin/element-types');
            exit;
        }

        View::render([
            'view' => 'Admin/ElementType/Edit',
            'title' => 'Editando Tipo de Elemento',
            'layout' => 'Admin/AdminLayout',
            'data' => ['element_type' => $element_type],
        ]);
    }

    public function update($id, $postData)
    {
        $element_type = ElementType::find($id);

        if ($element_type) {
            $element_type->name = $postData['name'];
            $element_type->description = $postData['description'];
            $element_type->icon = $postData['icon'];
            $element_type->color = $postData['color'];

            $element_type->save();

            Session::set('success', 'Tipo de elemento actualizado correctamente');
        } else {
            Session::set('error', 'Tipo de elemento no encontrado');
        }

        header('Location: /admin/element-types');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $element_type = ElementType::find($id);

        if ($element_type) {
            $element_type->delete();
            Session::set('success', 'Tipo de elemento eliminado correctamente');
        } else {
            Session::set('error', 'Tipo de elemento no encontrado');
        }

        header('Location: /admin/element-types');
        exit;
    }
}
