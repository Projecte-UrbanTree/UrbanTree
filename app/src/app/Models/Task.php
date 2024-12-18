<?php

namespace App\Models;

class Task extends BaseModel
{
    public string $name;
    public string $description;


    protected static function getTableName(): string
    {
        return 'tasks';
    }

    protected static function mapDataToModel($data): Task
    {
        $task = new self();
        $task->id = $data['id'];
        $task->name = $data['name'];
        $task->description = $data['description'];

        return $task;
    }

    public function taskType(): TaskType
    {
        return $this->belongsTo(TaskType::class, 'task_type_id', 'id');
    }
}
