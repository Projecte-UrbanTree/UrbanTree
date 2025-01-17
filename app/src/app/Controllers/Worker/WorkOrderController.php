<?php

namespace App\Controllers\Worker;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\WorkOrderBlockTask;
use App\Models\WorkOrderUser;
use App\Models\WorkReport;
use App\Models\Resource;
use App\Models\WorkReportResource;

class WorkOrderController
{
    public function index($queryParams)
    {
        $date = $queryParams['date'] ?? date('Y-m-d');
        $userId = Session::get('user')['id'];
        $workOrderId = $queryParams['work_order_id'] ?? null;
        $work_report = WorkReport::findAll();
        $resources = Resource::findAll();
        $work_report_resources = WorkReportResource::findAll();

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
                'resources' => $resources,
                'spent_fuel' => $work_report->spent_fuel ?? 0.0,
                'work_report_resources' => $work_report_resources,
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
            }
        }

        if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            echo json_encode(['success' => true]);
            exit;
        } else {
            header('Location: /worker/work-orders?date='.$postData['date']);
            exit;
        }
    }

    public function storeReport($postData)
    {   
        foreach ($postData['spent_time'] as $taskId => $time) {
            $task = WorkOrderBlockTask::find($taskId);
            if ($task) {
                $task->spent_time = $time;
                $task->save();
            }
        }

        $work_report = WorkReport::findBy(['work_order_id' => $postData['work_order_id']], true);
        if (!$work_report) {
            $work_report = new WorkReport();
            $work_report->work_order_id = $postData['work_order_id'];
        }

        $work_report->spent_fuel = isset($postData['spent_fuel']) ? (float) $postData['spent_fuel'] : 0.0;
        $work_report->observation = $postData['observation'];
        $work_report->save();

        if (isset($postData['resource_id'])) {
            foreach ($postData['resource_id'] as $resourceId) {
                $work_report_resource = new WorkReportResource();
                $work_report_resource->work_report_id = $work_report->getId();
                $work_report_resource->resource_id = $resourceId;
                $work_report_resource->save();
            }
        }

        header('Location: /worker/work-orders?work_order_id=' . $postData['work_order_id']);
        exit;
    }
}
