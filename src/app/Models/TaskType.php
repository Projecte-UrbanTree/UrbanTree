<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Core\Database;

class TaskType extends BaseModel
{
    public string $name;

    // s'ha de definir les classes abstractes
    protected static function getTableName()
    {
        return 'task_types';
    }


    protected static function mapDataToModel($data)
    {
        $task = new TaskType();
        $task->id = $data['id'];
        $task->name = $data['name'];
        return $task;
    }
}