<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Contract;
use App\Models\Element;
use App\Models\Point;
use App\Models\TreeType;
use App\Models\Zone;
use App\Models\ElementType;

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
        $contracts = Contract::findAll();
        $element_types = ElementType::findAll();
        View::render([
            'view' => 'Admin/Element/Create',
            'title' => 'Add Element',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'zones' => $zones,
                'types' => $types,
                'contracts' => $contracts,
                'element_types' => $element_types,
            ],
        ]);
    }

    public function store($postData)
    {
        $element = new Element();
        $element->element_type_id = $postData['element_type_id'];
        $element->zone_id = $postData['zone_id'];
        $element->contract_id = $postData['contract_id'];
        $element->tree_type_id = $postData['tree_type_id'];

        $element->save();

        Session::set('success', 'Element created successfully');

        header('Location: /admin/elements');
    }

    public function edit($id, $queryParams)
    {
        $element = Element::find($id);
        $zones = Zone::findAll();
        $types = TreeType::findAll();
        $contracts = Contract::findAll();
        $element_types = ElementType::findAll();
        View::render([
            'view' => 'Admin/Element/Edit',
            'title' => 'Edit Element',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'element' => $element,
                'zones' => $zones,
                'types' => $types,
                'contracts' => $contracts,
                'element_types' => $element_types,
            ],
        ]);
    }

    public function update($id, $postData)
    {
        $element = Element::find($id);
        $element->element_type_id = $postData['element_type_id'];
        $element->zone_id = $postData['zone_id'];
        $element->point_id = $postData['point_id'];
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
