<?php

namespace App\Models;

class TaskType extends BaseModel
{
    public string $name;

    protected static function getTableName(): string
    {
        return 'task_types';
    }

    protected static function mapDataToModel($data): TaskType
    {
        $task_type = new self();
        $task_type->id = $data['id'];
        $task_type->name = $data['name'];
        $task_type->created_at = $data['created_at'];
        $task_type->updated_at = $data['updated_at'];
        $task_type->deleted_at = $data['deleted_at'];

        return $task_type;
    }
}
