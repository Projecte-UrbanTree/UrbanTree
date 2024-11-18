<?php

namespace App\Models;

class MWorkOrder extends BaseModel
{
    public ?int $contract_id;

    protected static function getTableName(): string
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data): MWorkOrder
    {
        $order = new self();
        $order->id = $data['id'];
        $order->contract_id = $data['contract_id'];
        $order->created_at = $data['created_at'];
        return $order;
    }

    public function report(): MWorkReport
    {
        return $this->hasMany(MWorkReport::class, 'id')[0];
    }

    public function contract(): MContract
    {
        return $this->belongsTo(MContract::class, 'contract_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(MTask::class, 'work_order_id', 'id');
    }
}
