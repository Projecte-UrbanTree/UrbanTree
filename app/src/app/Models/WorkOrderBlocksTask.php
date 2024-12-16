<?php
namespace App\Models;
class WorkOrderBlockTask extends BaseModel
{
    public int $work_order_id;
    public int $zone_id;
    public int $task_id;
    public ?string $notes;

    protected static function getTableName(): string
    {
        return 'work_orders_blocks_tasks';
    }

    protected static function mapDataToModel($data): workOrderBlockTask
    {
        $workOrderBlockTask = new self();
        $workOrderBlockTask->id = $data['id'];
        $workOrderBlockTask->work_order_id = $data['work_order_id'];
        $workOrderBlockTask->zone_id = $data['zone_id'];
        $workOrderBlockTask->task_id = $data['task_id'];
        $workOrderBlockTask->notes = $data['notes'];

        return $workOrderBlockTask;
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'work_orders_blocks_zones', 'work_orders_block_id', 'zone_id');
    }

    public function tasks()
    {
        return $this->hasMany(WorkOrderBlockTask::class, 'work_orders_block_id', 'id');
    }
}