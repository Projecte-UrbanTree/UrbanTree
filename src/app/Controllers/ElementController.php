<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Contract;
use App\Models\Element;
use App\Core\Session;
use App\Models\TreeType;
use App\Models\Zone;

class ElementController
{
    public function index()
    {
        $elements = Element::findAll();
        View::render([
            'view' => 'Elements',
            'title' => 'Manage Elements',
            'layout' => 'MainLayout',
            'data' => ['elements' => $elements],
        ]);
    }
    public function create(){
        $zones = Zone::findAll(); 
        $types = TreeType::findAll();
        $contracts = Contract::findAll();
        View::render([
            'view' => 'Element/Create',
            'title' => 'Add Element',
            'layout' => 'MainLayout',
            'data' => [
                'zones' => $zones,
                'types' => $types,
                'contracts'=> $contracts
            ],
        ]);
    }
    public function store($postData)
    {
        $element = new Element;
        $element->name = $postData['name'];
        $element->contract = $postData['contract_id'];
        $element->zone_id = $postData['zone_id'];
        // $element->point_id = $postData['point_id'];
        $element->tree_type_id = $postData['tree_type_id'];

        $element->save();

        Session::set('success', 'Element created successfully');

        header('Location: /elements');
    }

    public function edit($id)
    {
        $element = Element::find($id);
        View::render([
            'view' => 'Element/Edit',
            'title' => 'Edit Element',
            'layout' => 'MainLayout',
            'data' => ['element' => $element],
        ]);
    }

    public function update($id, $postData)
    {
        $element = Element::find($id);
        $element->name = $postData['name'];
        $element->contract = $postData['contract_id'];
        $element->zone_id = $postData['zone_id'];
        // $element->point_id = $postData['point_id'];
        $element->tree_type_id = $postData['tree_type_id'];
        $element->save();

        Session::set('success', 'Element updated successfully');

        header('Location: /elements');
    }

    public function destroy($id)
    {
        $element = Element::find($id);
        $element->delete();

        Session::set('success', 'Element deleted successfully');

        header('Location: /elements');
    }
}
