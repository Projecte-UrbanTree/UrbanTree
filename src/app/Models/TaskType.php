<?php

namespace App\Models;

class TaskType extends BaseModel
{
    public string $name;

    protected static function getTableName()
    {
        return 'task_types';
    }

    protected static function mapDataToModel($data)
    {
        $task = new TaskType();
        $task->id = $data['id'];
        $task->name = $data['name'];
        $task->created_at = $data['created_at'];

        return $task;
    }
}
