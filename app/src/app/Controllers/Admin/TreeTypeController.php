<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\TreeType;

class TreeTypeController
{
    public function index($queryParams)
    {
        $tree_types = TreeType::findAll();
        View::render([
            'view' => 'Admin/TreeTypes',
            'title' => 'Tree Types',
            'layout' => 'Admin/AdminLayout',
            'data' => ['tree_types' => $tree_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TreeType/Create',
            'title' => 'Create TreeTypes',
            'layout' => 'Admin/AdminLayout',
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

        header('Location: /admin/tree-types');
    }

    public function edit($id, $queryParams)
    {
        $tree_type = TreeType::find($id);

        View::render([
            'view' => 'Admin/TreeType/Edit',
            'title' => 'Edit Tree Type',
            'layout' => 'Admin/AdminLayout',
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

        header('Location: /admin/tree-types');
    }

    public function destroy($id, $queryParams)
    {
        $treetypes = TreeType::find($id);
        $treetypes->delete();

        header('Location: /admin/tree-types');
    }
}
