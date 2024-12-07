<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Element;
use App\Models\TreeType;
use App\Models\Zone;

class ElementController
{
    public function index($queryParams)
    {
        $elements = Element::findAll();
        View::render([
            'view' => 'Admin/Elements',
            'title' => 'Manage Elements',
            'layout' => 'Admin/AdminLayout',
            'data' => ['elements' => $elements],
        ]);
    }

    public function create($queryParams)
    {
        $zones = Zone::findAll();
        $types = TreeType::findAll();
        View::render([
            'view' => 'Admin/Element/Create',
            'title' => 'Add Element',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'zones' => $zones,
                'types' => $types,
            ],
        ]);
    }

    public function store($postData)
    {
        $element = new Element();
        $element->name = $postData['name'];
        $element->zone_id = $postData['zone_id'];
        // $element->point_id = $postData['point_id'];
        $element->tree_type_id = $postData['tree_type_id'];

        $element->save();

        Session::set('success', 'Element created successfully');

        header('Location: /admin/elements');
    }

    public function edit($id, $queryParams)
    {
        $element = Element::find($id);
        View::render([
            'view' => 'Admin/Element/Edit',
            'title' => 'Edit Element',
            'layout' => 'Admin/AdminLayout',
            'data' => ['element' => $element],
        ]);
    }

    public function update($id, $postData)
    {
        $element = Element::find($id);
        $element->name = $postData['name'];
        $element->zone_id = $postData['zone_id'];
        // $element->point_id = $postData['point_id'];
        $element->tree_type_id = $postData['tree_type_id'];
        $element->save();

        Session::set('success', 'Element updated successfully');

        header('Location: /admin/elements');
    }

    public function destroy($id, $queryParams)
    {
        $element = Element::find($id);
        $element->delete();

        Session::set('success', 'Element deleted successfully');

        header('Location: /admin/elements');
    }
}
