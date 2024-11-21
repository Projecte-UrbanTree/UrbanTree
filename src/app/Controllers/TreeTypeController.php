<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\TreeType;

class TreeTypeController
{
    public function index()
    {
        $tree_types = TreeType::findAll();
        View::render([
            'view' => 'TreeTypes',
            'title' => 'Tree Types',
            'layout' => 'MainLayout',
            'data' => ['tree_types' => $tree_types],
        ]);
    }

    public function create()
    {
        View::render([
            'view' => 'TreeTypes/Create',
            'title' => 'Create TreeTypes',
            'layout' => 'MainLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $tree_types = new TreeType;
        $tree_types->family = $postData['Family'];
        $tree_types->genus = $postData['Genus'];
        $tree_types->species = $postData['Species'];
        $tree_types->save();


        header(header:'Location: /tree-types');
        exit;
    }



}
