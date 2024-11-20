<?php

namespace App\Models;

class TaskType extends BaseModel
{
    public string $name;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'task_types';
    }

    protected static function mapDataToModel($data): TaskType
    {
        $task = new self();
        $task->id = $data['id'];
        $task->name = $data['name'];
        $task->photo_id = $data['photo_id'];
        $task->created_at = $data['created_at'];

        return $task;
    }

    public function photo(): ?Photo
    {
        if ($this->photo_id)
            return $this->belongsTo(Photo::class, 'photo_id');
    }
}
