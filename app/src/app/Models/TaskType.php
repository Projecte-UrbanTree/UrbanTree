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
        $task_type = new self();
        $task_type->id = $data['id'];
        $task_type->name = $data['name'];
        $task_type->photo_id = $data['photo_id'];
        $task_type->created_at = $data['created_at'];
        $task_type->updated_at = $data['updated_at'];
        $task_type->deleted_at = $data['deleted_at'];

        return $task_type;
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
