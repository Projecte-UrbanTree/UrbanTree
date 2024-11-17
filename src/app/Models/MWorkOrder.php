<?php
namespace App\Models;

use App\Core\BaseModel;

class MWorkOrder extends BaseModel
{
    public int $contract_id;

    protected static function getTableName()
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data)
    {
        $order = new MWorkOrder();
        $order->id = $data['id'];
        $order->contract_id = $data['contract_id'];
        $order->created_at = $data['created_at'];

        return $order;
    }

    public function contract()
    {
        return $this->belongsTo(MContract::class, 'contract_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(MTask::class, 'work_order_id', 'id');
    }
}