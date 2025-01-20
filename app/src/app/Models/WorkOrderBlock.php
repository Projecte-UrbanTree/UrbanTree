<?php

namespace App\Models;

class WorkOrderBlock extends BaseModel
{
    public int $work_order_id;

    public ?string $notes;

    protected static function getTableName(): string
    {
        return 'work_orders_blocks';
    }

    protected static function mapDataToModel($data): WorkOrderBlock
    {
        $work_order_block = new self;
        $work_order_block->id = $data['id'];
        $work_order_block->work_order_id = $data['work_order_id'];
        $work_order_block->notes = $data['notes'];

        return $work_order_block;
    }

    public function workOrder(): WorkOrder
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function zones(): array
    {
        return $this->belongsToMany(Zone::class, 'work_orders_blocks_zones', 'work_orders_block_id', 'zone_id');
    }

    public function tasks(): array
    {
        return $this->hasMany(WorkOrderBlockTask::class, 'work_orders_block_id');
    }
}
