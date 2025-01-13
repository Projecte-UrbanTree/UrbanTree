<?php

namespace App\Controllers\Worker;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\WorkOrderBlockTask;
use App\Models\WorkOrderUser;

class WorkOrderController
{
    public function index($queryParams)
    {
        $date = $queryParams['date'] ?? date('Y-m-d');
        $userId = Session::get('user')['id'];

        $work_orders_user = WorkOrderUser::findAll(['user_id' => $userId]);
        $work_order_ids = array_column($work_orders_user, 'work_order_id');

        $work_orders = $work_order_ids
            ? WorkOrder::findAll(['id' => $work_order_ids, 'date' => $date])
            : [];

        View::render([
            'view' => 'Worker/WorkOrders',
            'title' => 'Órdenes de Trabajo',
            'layout' => 'Worker/WorkerLayout',
            'data' => [
                'date' => $date,
                'work_orders' => $work_orders,
            ],
        ]);
    }

    public function updateStatus($postData)
    {
        if (isset($postData['tasks'])) {
            foreach ($postData['tasks'] as $taskId => $status) {
                $task = WorkOrderBlockTask::find($taskId);
                if ($task) {
                    $task->status = $status;
                    $task->save();
                }
            }
        }

        header('Location: /worker/work-orders?date=' . $postData['date']);
        exit;
    }
}