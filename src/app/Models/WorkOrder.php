<?php

namespace App\Models;

class WorkOrder extends BaseModel
{
    public ?int $contract_id;

    protected static function getTableName(): string
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data): WorkOrder
    {
        $WorkOrder = new self();
        $WorkOrder->id = $data['id'];
        $WorkOrder->contract_id = $data['contract_id'];
        $WorkOrder->created_at = $data['created_at'];

        return $WorkOrder;
    }

    public function report(): WorkReport
    {
        return $this->hasOne(WorkReport::class, 'id');
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'work_order_id', 'id');
    }
}
