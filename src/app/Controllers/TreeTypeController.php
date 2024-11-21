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
        $tree_types->family = $postData['family'];
        $tree_types->genus = $postData['fenus'];
        $tree_types->species = $postData['species'];
        $tree_types->save();


        header(header:'Location: /tree-types');
        exit;
    }
    public function edit($id)
    {
        $tree_type = TreeType::find($id);
        View::render([
            'view' => 'TreeTypes/Edit',
            'title' => 'Edit Tree Type',
            'layout' => 'MainLayout',
            'data' => ['tree_type' => $tree_type],
        ]);
    }

    public function update($id, $postData)
    {
    // Cerca el tipus d'arbre a la base de dades pel seu ID
        $treetypes = TreeType::find($id);

        if ($TreeTypes) {
            $tree_types->family = $postData['family'];
            $tree_types->genus = $postData['genus'];
            $tree_types->species = $postData['species'];

            $tree_types->save();


        header('Location: /tree-types');

    }

}
    public function destroy($id)
    {
        $treetypes = TreeType::find($id);
        $treetypes->delete();


        header('Location: /tree-types');
    }
}