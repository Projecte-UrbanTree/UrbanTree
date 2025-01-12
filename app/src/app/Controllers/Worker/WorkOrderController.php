<?php

namespace App\Controllers\Worker;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\TaskType;
use App\Models\Zone;
use App\Models\User;
use App\Models\TreeType;
use App\Models\WorkOrderBlock;
use App\Models\WorkOrderBlockTask;
use App\Models\WorkOrderUser;
use App\Models\WorkOrderBlockZone;

class WorkOrderController
{

    public function index($queryParams)
    {
        $date = $queryParams['date'] ?? date('Y-m-d');
        $userId = Session::get('user')['id'];

        $work_orders_user = WorkOrderUser::findAll(['user_id' => $userId]);
        $word_orders_ids = array_column($work_orders_user, 'work_order_id');
        // die(var_dump($work_order_user));
        $work_orders = $work_orders_user
            ? WorkOrder::findAll(['id' => array_column($work_orders_user, 'work_order_id')])
            : [];

        View::render([
            'view' => 'Worker/WorkOrders',
            'title' => 'Órdenes de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'date' => $date,
                'previous_work_order' => '',
                'work_order' => '',
                'next_work_order' => '',
            ],
        ]);
    }
}