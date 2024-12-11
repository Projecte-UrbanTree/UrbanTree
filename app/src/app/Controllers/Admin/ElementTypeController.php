<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
//use App\Models\Element;
use App\Models\ElementType;

class ElementTypeController
{
    public function index($queryParams)
    {
        $elementTypes = ElementType::findAll();
        View::render([
            'view' => 'Admin/ElementTypes',
            'title' => 'Manage Elements Types',
            'layout' => 'Admin/AdminLayout',
            'data' => ['elementTypes' => $elementTypes],
        ]);
    }

    public function create($queryParams)
    {
        //$elements = Element::findAll();
        View::render([
            'view' => 'Admin/ElementType/Create',
            'title' => 'Add Element Type',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                //'elements' => $elements,
            ],
        ]);
    }

    public function store($postData)
    {
        $elementType = new ElementType();
        $elementType->name = $postData['name'];
        $elementType->description = $postData['description'];

        $elementType->save();

        Session::set('success', 'Type of Element created successfully');

        header('Location: /admin/element-types');
    }

    public function edit($id, $queryParams)
    {
        $elementType = ElementType::find($id);
        View::render([
            'view' => 'Admin/ElementType/Edit',
            'title' => 'Edit Element Type',
            'layout' => 'Admin/AdminLayout',
            'data' => ['elementType' => $elementType],
        ]);
    }

    public function update($id, $postData)
    {
        $elementType = ElementType::find($id);
        $elementType->name = $postData['name'];
        $elementType->description = $postData['description'];
        $elementType->save();

        Session::set('success', 'Type of Element updated successfully');

        header('Location: /admin/element-types');
    }

    public function destroy($id, $queryParams)
    {
        $elementType = ElementType::find($id);
        $elementType->delete();

        Session::set('success', 'Type of Element deleted successfully');

        header('Location: /admin/element-types');
    }
}
