<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MTaskType;

class CTaskType
{
    public function index()
    {
        $task_types = MTaskType::findAll();
        View::render([
            "view" => "TaskType",
            "title" => "Task Types",
            "layout" => "MainLayout",
            "data" => ["task_types" => $task_types]
        ]);
    }
}
