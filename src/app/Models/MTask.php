<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Models\MWorkOrder;

class MTask extends BaseModel
{    
    public ?string $notes;
    public $work_order_id;

    protected static function getTableName()
    {
        return 'tasks';
    }

    protected static function mapDataToModel($data)
    {
        $task = new MTask();
        $task->id = $data['id'];
        $task->notes = $data['notes'];
        $task->work_order_id = $data['work_order_id'];
        $task->created_at = $data['created_at'];
        return $task;
    }

    public function Order() {
        return $this->belongsTo(MWorkOrder::class, 'work_order_id', 'id');
    }

    // Many-to-Many relationship with Post
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