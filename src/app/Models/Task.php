<?php

namespace App\Models;

class Task extends BaseModel
{
    public ?string $notes;
    public $work_order_id;

    public function Order()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    // Many-to-Many relationship with Post
    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'tasks_zones', 'task_id', 'zone_id');
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'tasks_workers', 'task_id', 'worker_id');
    }

    public function taskTypes()
    {
        return $this->belongsToMany(TaskType::class, 'tasks_tasktypes', 'task_id', 'tasktype_id');
    }

    protected static function getTableName()
    {
        return 'tasks';
    }

    protected static function mapDataToModel($data)
    {
        $task = new Task();
        $task->id = $data['id'];
        $task->notes = $data['notes'];
        $task->work_order_id = $data['work_order_id'];
        $task->created_at = $data['created_at'];

        return $task;
    }
}
