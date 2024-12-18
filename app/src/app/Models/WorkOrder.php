<?php

namespace App\Models;

class WorkOrder extends BaseModel
{
    public int $contract_id;
    public string $date;

    protected static function getTableName(): string
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data): WorkOrder
    {
        $WorkOrder = new self();
        $WorkOrder->id = $data['id'];
        $WorkOrder->contract_id = $data['contract_id'];
        $WorkOrder->date = $data['date'];

        return $WorkOrder;
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function users(): array
    {
        return $this->belongsToMany(User::class, 'work_orders_users', 'work_order_id', 'user_id');
    }

    public function blocks()
    {
        return $this->hasMany(WorkOrderBlock::class, 'work_order_id', 'id');
    }
}
