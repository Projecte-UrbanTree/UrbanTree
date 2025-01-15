<?php
namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Resource;
use App\Models\TypeResource;

class ResourceController
{
    public function index($queryParams)
    {
        $resources = Resource::findAll();
        $resource_types = TypeResource::findAll();

        return View::render([
            'view' => 'Admin/Resources',
            'title' => 'Recursos',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'resources' => $resources,
                'resource_types' => $resource_types
            ]
        ]);
    }

    public function create($queryParams)
    {
        $resource_types = TypeResource::findAll();

        View::render([
            'view' => 'Admin/Resource/Create',
            'title' => 'Crear Recurso',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'resource_types' => $resource_types
            ]
        ]);
    }

    public function store($postData)
    {
        $resource = new Resource();
        $resource->name = $postData['name'];
        $resource->description = $postData['description'];
        $resource->type_resource_id = (int) $postData['type_resource_id'];
        $resource->save();
        var_dump($resource);

        if ($resource->getId())
            Session::set('success', 'Recurso creado correctamente');
        else
            Session::set('error', 'El recurso no se pudo crear');

        header('Location: /admin/resources');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            Session::set('error', 'Recurso no encontrado');
            header('Location: /admin/resources');
            exit;
        }
        $resource_types = TypeResource::findAll();

        View::render([
            'view' => 'Admin/Resource/Edit',
            'title' => 'Editar Recurso',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'resource' => $resource,
                'resource_types' => $resource_types
            ]
        ]);
    }

    public function update($id, $postData)
    {
        if (empty($postData['type_resource_id'])) {
            Session::set('error', 'El tipo de recurso es obligatorio');
            header('Location: /admin/resource/' . $id . '/edit');
            exit;
        }

        $resource = Resource::find($id);
        $resource->name = $postData['name'];
        $resource->description = $postData['description'];
        $resource->type_resource_id = $postData['type_resource_id'];
        $resource->save();

        if ($resource->getId())
            Session::set('success', 'Recurso actualizado correctamente');
        else
            Session::set('error', 'El recurso no se pudo actualizar');

        header('Location: /admin/resources');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $resource = Resource::find($id);

        if ($resource) {
            $resource->delete();
            Session::set('success', 'Recurso eliminado correctamente');
        } else
            Session::set('error', 'Recurso no encontrado');


        header('Location: /admin/resources');
        exit;
    }
}