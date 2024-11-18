<?php

namespace App\Models;

use App\Models\MWorkOrder;

class MTask extends BaseModel
{
    public int $work_order_id;
    public ?string $notes;

    protected static function getTableName(): string
    {
        return 'tasks';
    }

    protected static function mapDataToModel($data): MTask
    {
        $task = new self();
        $task->id = $data['id'];
        $task->notes = $data['notes'];
        $task->work_order_id = $data['work_order_id'];
        $task->created_at = $data['created_at'];
        return $task;
    }

    public function order(): MWorkOrder
    {
        return $this->belongsTo(MWorkOrder::class, 'work_order_id', 'id');
    }

    public function zones()
    {
        return $this->belongsToMany(MZone::class, 'tasks_zones', 'task_id', 'zone_id');
    }

    public function workers()
    {
        return $this->belongsToMany(MWorker::class, 'tasks_workers', 'task_id', 'worker_id');
    }

    public function taskTypes()
    {
        return $this->belongsToMany(MTaskType::class, 'tasks_tasktypes', 'task_id', 'tasktype_id');
    }
}
