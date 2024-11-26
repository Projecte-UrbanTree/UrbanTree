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
            'view' => 'TreeType/Create',
            'title' => 'Create TreeTypes',
            'layout' => 'MainLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $tree_type = new TreeType();

        $tree_type->family = $postData['family'];
        $tree_type->genus = $postData['genus'];
        $tree_type->species = $postData['species'];
        $tree_type->save();

        header('Location: /tree-types');
    }
    public function edit($id)
    {
        $tree_type = TreeType::find($id);

        View::render([
            'view' => 'TreeType/Edit',
            'title' => 'Edit Tree Type',
            'layout' => 'MainLayout',
            'data' => ['tree_type' => $tree_type],
        ]);
    }

    public function update($id, $postData)
    {
        $treetypes = TreeType::find($id);

        if ($treetypes) {
            $treetypes->family = $postData['family'];
            $treetypes->genus = $postData['genus'];
            $treetypes->species = $postData['species'];
            $treetypes->save();
        }

        header('Location: /tree-types');


    }
    public function destroy($id)
    {
        $treetypes = TreeType::find($id);
        $treetypes->delete();

        header('Location: /tree-types');
    }
}
