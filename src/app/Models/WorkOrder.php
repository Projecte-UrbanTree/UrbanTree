<?php

namespace App\Models;

class WorkOrder extends BaseModel
{
    public int $contract_id;

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'work_order_id', 'id');
    }

    protected static function getTableName()
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data)
    {
        $order = new WorkOrder;
        $order->id = $data['id'];
        $order->contract_id = $data['contract_id'];
        $order->created_at = $data['created_at'];

        return $order;
    }
}
