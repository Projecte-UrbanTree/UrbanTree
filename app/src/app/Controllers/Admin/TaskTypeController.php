<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\TaskType;

class TaskTypeController
{
    public function index($queryParams)
    {
        $task_types = TaskType::findAll();
        View::render([
            'view' => 'Admin/TaskTypes',
            'title' => 'Tipos de Tarea',
            'layout' => 'Admin/AdminLayout',
            'data' => ['task_types' => $task_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TaskType/Create',
            'title' => 'Nuevo Tipo de Tarea',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $task_type = new TaskType();
        $task_type->name = $postData['name'];

        $task_type->save();

        if ($task_type->getId())
            Session::set('success', 'Tipo de tarea creado correctamente');
        else
            Session::set('error', 'El tipo de tarea no se pudo crear');

        header('Location: /admin/task-types');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $task_type = TaskType::find($id);

        if (!$task_type) {
            Session::set('error', 'Tipo de tarea no encontrado');
            header('Location: /admin/task-types');
            exit;
        }

        View::render([
            'view' => 'Admin/TaskType/Edit',
            'title' => 'Editando Tipo de Tarea',
            'layout' => 'Admin/AdminLayout',
            'data' => ['task_type' => $task_type],
        ]);
    }

    public function update($id, $postData)
    {
        $task_type = TaskType::find($id);

        if ($task_type) {
            $task_type->name = $postData['name'];

            $task_type->save();

            Session::set('success', 'Tipo de tarea actualizado correctamente');
        } else {
            Session::set('error', 'Tipo de tarea no encontrado');
        }

        header('Location: /admin/task-types');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $task_type = TaskType::find($id);

        if ($task_type) {
            $task_type->delete();
            Session::set('success', 'Tipo de tarea eliminado correctamente');
        } else
            Session::set('error', 'Tipo de tarea no encontrado');

        header('Location: /admin/task-types');
        exit;
    }
}
