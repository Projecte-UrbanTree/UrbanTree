<?php

namespace App\Models;

class WorkOrderBlockZone extends BaseModel
{
    public int $work_orders_block_id;

    public int $zone_id;

    protected static function getTableName(): string
    {
        return 'work_orders_blocks_zones';
    }

    protected static function mapDataToModel($data): WorkOrderBlockZone
    {
        $work_order_block_zone = new self();
        $work_order_block_zone->id = $data['id'];
        $work_order_block_zone->work_orders_block_id = $data['work_orders_block_id'];
        $work_order_block_zone->zone_id = $data['zone_id'];

        return $work_order_block_zone;
    }
}
