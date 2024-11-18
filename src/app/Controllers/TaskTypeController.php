<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\TaskType;

class TaskTypeController
{
    public function index()
    {
        $task_types = TaskType::findAll();
        View::render([
            'view' => 'TaskTypes/index',
            'title' => 'Task Types',
            'layout' => 'MainLayout',
            'data' => ['task_types' => $task_types],
        ]);
    }
}