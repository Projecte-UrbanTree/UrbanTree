<?php

namespace App\Models;

class WorkOrderUser extends BaseModel
{
    public int $work_order_id;

    public int $user_id;

    protected static function getTableName(): string
    {
        return 'work_orders_users';
    }

    protected static function mapDataToModel($data): WorkOrderUser
    {
        $work_order_user = new self;
        $work_order_user->id = $data['id'];
        $work_order_user->work_order_id = $data['work_order_id'];
        $work_order_user->user_id = $data['user_id'];
        $work_order_user->created_at = $data['created_at'];
        $work_order_user->updated_at = $data['updated_at'];
        $work_order_user->deleted_at = $data['deleted_at'];

        return $work_order_user;
    }
}
