<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\TaskType;

class TaskTypeController
{
    public function index($queryParams)
    {
        $task_types = TaskType::findAll();
        View::render([
            'view' => 'Admin/TaskTypes',
            'title' => 'Task Types',
            'layout' => 'Admin/AdminLayout',
            'data' => ['task_types' => $task_types],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/TaskType/Create',
            'title' => 'Add Task Type',
            'layout' => 'Admin/AdminLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $tasktype = new TaskType();
        $tasktype->name = $postData['name'];
        $tasktype->save();

        header('Location: /admin/task-types');
    }

    public function edit($id, $queryParams)
    {
        $tasktype = TaskType::find($id);
        View::render([
            'view' => 'Admin/TaskType/Edit',
            'title' => 'Edit Task Type',
            'layout' => 'Admin/AdminLayout',
            'data' => ['task_type' => $tasktype],
        ]);
    }

    public function update($id, $postData)
    {
        $tasktype = TaskType::find($id);

        $tasktype->name = $postData['name'];
        $tasktype->save();

        header('Location: /admin/task-types');
    }

    public function destroy($id, $queryParams)
    {
        TaskType::find($id)->delete();

        header('Location: /admin/task-types');
    }
}
