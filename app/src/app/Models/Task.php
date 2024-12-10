<?php

namespace App\Models;

class Task extends BaseModel
{
    public int $work_order_id;

    public int $task_type_id;

    public ?string $notes;

    public ?int $route_id;

    protected static function getTableName(): string
    {
        return 'tasks';
    }

    protected static function mapDataToModel($data): Task
    {
        $task = new self();
        $task->id = $data['id'];
        $task->work_order_id = $data['work_order_id'];
        $task->task_type_id = $data['task_type_id'];
        $task->notes = $data['notes'];
        $task->route_id = $data['route_id'];
        $task->created_at = $data['created_at'];
        $task->updated_at = $data['updated_at'];
        $task->deleted_at = $data['deleted_at'];

        return $task;
    }

    public function order(): WorkOrder
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function taskType(): TaskType
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'tasks_zones', 'task_id', 'zone_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tasks_users', 'task_id', 'user_id');
    }
}
