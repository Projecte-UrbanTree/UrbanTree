<?php

namespace App\Controllers\Worker;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\WorkOrderBlockTask;
use App\Models\WorkOrderUser;
use App\Models\WorkReport;

class WorkOrderController
{
    public function index($queryParams)
    {
        $date = $queryParams['date'] ?? date('Y-m-d');
        $userId = Session::get('user')['id'];
        $workOrderId = $queryParams['work_order_id'] ?? null;
        $work_report = WorkReport::findAll();

        if ($workOrderId) {
            $work_orders = WorkOrder::findAll(['id' => $workOrderId]);
        } else {
            $work_orders_user = WorkOrderUser::findAll(['user_id' => $userId]);
            $work_order_ids = array_column($work_orders_user, 'work_order_id');

            $work_orders = $work_order_ids
                ? WorkOrder::findAll(['id' => $work_order_ids, 'date' => $date])
                : [];
        }

        View::render([
            'view' => 'Worker/WorkOrders',
            'title' => 'Órdenes de Trabajo',
            'layout' => 'Worker/WorkerLayout',
            'data' => [
                'date' => $date,
                'work_orders' => $work_orders,
                'work_report' => $work_report,
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

                $block = $task->block();
                $work_order = WorkOrder::find($block->work_order_id);
                if ($work_order) {
                    $allTasksCompleted = true;
                    $hasInProgress = false;

                    foreach ($work_order->blocks() as $block) {
                        foreach ($block->tasks() as $task) {
                            if ($task->status == 1) {
                                $hasInProgress = true;
                            } elseif ($task->status == 0) {
                                $allTasksCompleted = false;
                            }
                        }
                    }

                    if ($allTasksCompleted) {
                        $work_order->status = 2; // Complete (Green)
                    } elseif ($hasInProgress) {
                        $work_order->status = 1; // In Progress (Orange)
                    } else {
                        $work_order->status = 0; // Not Started  (Red)
                    }

                    $work_order->save();
                }
            }
        }

        header('Location: /worker/work-orders?date=' . $postData['date']);
        exit;
    }

    public function storeReport()
    {

    }
}