<?php

namespace App\Models;

use App\Core\Database;

class WorkOrder extends BaseModel
{
    public int $contract_id;
    public string $date;
    public int $status;

    protected static function getTableName(): string
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data): WorkOrder
    {
        $work_order = new self();
        $work_order->id = $data['id'];
        $work_order->contract_id = $data['contract_id'];
        $work_order->date = $data['date'];
        $work_order->status = $data['status'];
        $work_order->created_at = $data['created_at'];
        $work_order->updated_at = $data['updated_at'];
        $work_order->deleted_at = $data['deleted_at'];

        return $work_order;
    }

    public function report(): WorkReport
    {
        return $this->hasOne(WorkReport::class, 'id');
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function users(): array
    {
        return $this->belongsToMany(User::class, 'work_orders_users', 'work_order_id', 'user_id');
    }

    public function blocks(): array
    {
        return $this->hasMany(WorkOrderBlock::class, 'work_order_id');
    }
}
