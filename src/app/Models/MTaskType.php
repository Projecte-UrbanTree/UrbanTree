<?php

namespace App\Models;

use App\Core\BaseModel;

class MTaskType extends BaseModel
{
    public string $name;

    protected static function getTableName()
    {
        return 'task_types';
    }

    protected static function mapDataToModel($data)
    {
        $task = new MTaskType();
        $task->id = $data['id'];
        $task->name = $data['name'];
        $task->created_at = $data['created_at'];
        return $task;
    }
}
