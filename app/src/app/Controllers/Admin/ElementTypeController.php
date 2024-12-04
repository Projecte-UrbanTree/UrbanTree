<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\ElementType;

class ElementTypeController
{
    // Listar todos los tipos de elemento
    public function index($queryParams)
    {
        $elementTypes = ElementType::findAll();
        View::render([
            'view' => 'Admin/ElementType/Index',
            'title' => 'Manage Element Types',
            'layout' => 'Admin/AdminLayout',
            'data' => ['elementTypes' => $elementTypes],
        ]);
    }

    // Mostrar formulario para crear un tipo de elemento
    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/ElementType/Create',
            'title' => 'Create Element Type',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    // Guardar un nuevo tipo de elemento
    public function store($postData)
    {
        $element_type = new ElementType();
        $element_type->name = $postData['name'];
        $element_type->description = $postData['description'];

        $element_type->save();

        Session::set('success', 'Element Type created successfully');
        header('Location: /admin/element-types');
    }

    // Editar un tipo de elemento
    public function edit($id, $queryParams)
    {
        $element_type = ElementType::find($id);
        View::render([
            'view' => 'Admin/ElementType/Edit',
            'title' => 'Edit Element Type',
            'layout' => 'Admin/AdminLayout',
            'data' => ['element_type' => $element_type],
        ]);
    }

    // Actualizar un tipo de elemento
    public function update($id, $postData)
    {
        $element_type = ElementType::find($id);
        $element_type->name = $postData['name'];
        $element_type->description = $postData['description'];

        $element_type->save();

        Session::set('success', 'Element Type updated successfully');
        header('Location: /admin/element-types');
    }

    // Eliminar un tipo de elemento
    public function destroy($id, $queryParams)
    {
        $element_type = ElementType::find($id);
        $element_type->delete();

        Session::set('success', 'Element Type deleted successfully');
        header('Location: /admin/element-types');
    }
}
