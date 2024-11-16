<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\TaskType;

class TaskTypeController implements BaseController
{
    public function get()
    {
        $task_types = TaskType::findAll();
        View::render([
            "view" => "TaskTypes/index",
            "title" => "Task Types",
            "layout" => "MainLayout",
            "data" => ["task_types" => $task_types]
        ]);
    }

    public function post()
    {
    }
    public function put()
    {
    }
    public function delete()
    {
    }
}
