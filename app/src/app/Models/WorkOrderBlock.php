<?php

namespace App\Models;
class WorkOrderBlock extends BaseModel
{
    public int $work_order_id;
    public int $zone_id;
    public int $task_id;
    public ?string $notes;

    protected static function getTableName(): string
    {
        return 'work_order_blocks';
    }

    protected static function mapDataToModel($data): WorkOrderBlock
    {
        $workOrderBlock = new self();
        $workOrderBlock->id = $data['id'];
        $workOrderBlock->work_order_id = $data['work_order_id'];
        $workOrderBlock->zone_id = $data['zone_id'];
        $workOrderBlock->task_id = $data['task_id'];
        $workOrderBlock->notes = $data['notes'];

        return $workOrderBlock;
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'work_orders_blocks_zone', 'work_order_block_id', 'zone_id');
    }

    public function tasks()
    {
        return $this->hasMany(WorkOrderBlockTask::class, 'work_orders_block_id', 'id');
    }
}
