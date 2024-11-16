<?php
namespace App\Models;

use App\Core\BaseModel;
use App\Core\Database;

class Order extends BaseModel
{   
    public string $name;
    public int $contract_id;
    public string $notes;
    protected $created_at;

    protected static function getTableName()
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data)
    {
        $order = new Order();
        $order->id = $data['id'];
        $order->name = $data['name'];
        $order->contract_id = $data['contract_id'];
        $order->notes = $data['notes'];
        $order->created_at = $data['created_at'];

        return $order;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}