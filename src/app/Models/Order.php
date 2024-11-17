<?php
namespace App\Models;

use App\Core\BaseModel;

class Order extends BaseModel
{   
    public int $contract_id;
    protected $created_at;

    protected static function getTableName()
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data)
    {
        $order = new Order();
        $order->id = $data['id'];
        $order->contract_id = $data['contract_id'];
        $order->created_at = $data['created_at'];

        return $order;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'work_order_id', 'id');
    }
}