<?php

namespace App\Controllers\Admin;

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
        $work_orders = WorkOrder::findAll();
        View::render([
            'view' => 'Admin/WorkOrders',
            'title' => 'Órdenes de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => ['work_orders' => $work_orders],
        ]);
    }

    public function create($queryParams)
    {
        $task_types = TaskType::findAll();
        $users = User::findAll(['role' => 1]);
        $zones = Zone::findAll(['name' => 'not null']);
        $tree_types = TreeType::findAll();
        View::render([
            'view' => 'Admin/WorkOrder/Create',
            'title' => 'Nueva Orden de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'users' => $users,
                'zones' => $zones,
                'task_types' => $task_types,
                'tree_types' => $tree_types,
            ],
        ]);
    }

    public function store($postData)
    {
        try {
            $work_order = new WorkOrder();
            $work_order->contract_id = $_SESSION['current_contract'];
            $work_order->date = $postData['date'];
            $work_order->save();

            // Create user relationships
            foreach (explode(',', $postData['userIds']) as $userId) {
                $workOrderUser = new WorkOrderUser();
                $workOrderUser->work_order_id = (int) $work_order->getId();
                $workOrderUser->user_id = (int) $userId;
                $workOrderUser->save();
            }

            foreach ($postData['blocks'] as $blockData) {
                $block = new WorkOrderBlock();
                $block->work_order_id = (int) $work_order->getId();
                $block->notes = $blockData['notes'];
                $block->save();

                foreach (explode(',', $blockData['zonesIds']) as $zoneId) {
                    $blockZone = new WorkOrderBlockZone();
                    $blockZone->work_orders_block_id = (int) $block->getId();
                    $blockZone->zone_id = (int) $zoneId;
                    $blockZone->save();
                }

                foreach ($blockData['tasks'] as $taskData) {
                    $task = new WorkOrderBlockTask();
                    $task->work_orders_block_id = (int) $block->getId();
                    $task->task_id = (int) $taskData['taskType'];
                    $task->tree_type_id = !empty($taskData['species']) ? (int) $taskData['species'] : null;
                    $task->status = 1; // Default status
                    $task->save();
                }
            }

            if ($work_order->getId()) {
                Session::set('success', 'Orden de Trabajo creada correctamente');
            } else {
                Session::set('error', 'La orden de trabajo no se pudo crear');
            }

            header('Location: /admin/work-orders');
            exit;
        } catch (\Throwable $th) {
            Session::set('error', $th->getMessage());
            header('Location: /admin/work-order/create');
            exit;
        }

    }

    public function edit($id, $queryParams)
    {
        $work_order = WorkOrder::find($id);
        if (!$work_order) {
            Session::set('error', 'Orden de trabajo no encontrada');
            header('Location: /admin/work-orders');
            exit;
        }

        $task_types = TaskType::findAll();
        $users = User::findAll(['role' => 1]);
        $zones = Zone::findAll(['name' => 'not null']);
        $tree_types = TreeType::findAll();

        View::render([
            'view' => 'Admin/WorkOrder/Edit',
            'title' => 'Editando Orden de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'work_order' => $work_order,
                'users' => $users,
                'zones' => $zones,
                'task_types' => $task_types,
                'tree_types' => $tree_types,
            ],
        ]);
    }

    public function update($id, $postData)
    {
        var_dump($postData);
        try {
            $work_order = WorkOrder::find($id);

            if ($work_order) {
                $work_order->contract_id = $_SESSION['current_contract'];
                $work_order->date = $postData['date'];
                $work_order->save();

                WorkOrderUser::deleteAll(['work_order_id' => $work_order->getId()]);
                foreach (explode(',', $postData['userIds']) as $userId) {
                    $workOrderUser = new WorkOrderUser();
                    $workOrderUser->work_order_id = (int) $work_order->getId();
                    $workOrderUser->user_id = (int) $userId;
                    $workOrderUser->save();
                }

                $existingBlocks = $work_order->blocks();
                foreach ($existingBlocks as $existingBlock) {
                    // Eliminar zonas y tareas asociadas
                    $zones = WorkOrderBlockZone::findBy(['work_orders_block_id' => $existingBlock->getId()]);
                    foreach ($zones as $zone)
                        $zone->delete();
                    $tasks = WorkOrderBlockTask::findBy(['work_orders_block_id' => $existingBlock->getId()]);
                    foreach ($tasks as $task)
                        $task->delete();
                    $existingBlock->delete();
                }

                foreach ($postData['blocks'] as $blockData) {
                    if (empty($blockData['notes']) && empty($blockData['zonesIds']) && empty($blockData['tasks'])) {
                        continue;
                    }

                    $block = new WorkOrderBlock();
                    $block->work_order_id = (int) $work_order->getId();
                    $block->notes = $blockData['notes'] ?? '';
                    $block->save();

                    if (!empty($blockData['zonesIds'])) {
                        foreach (explode(',', $blockData['zonesIds']) as $zoneId) {
                            $blockZone = new WorkOrderBlockZone();
                            $blockZone->work_orders_block_id = (int) $block->getId();
                            $blockZone->zone_id = (int) $zoneId;
                            $blockZone->save();
                        }
                    }

                    if (!empty($blockData['tasks'])) {
                        foreach ($blockData['tasks'] as $taskData) {
                            $task = new WorkOrderBlockTask();
                            $task->work_orders_block_id = (int) $block->getId();
                            $task->task_id = (int) $taskData['taskType'];
                            $task->tree_type_id = !empty($taskData['species']) ? (int) $taskData['species'] : null;
                            $task->status = 1;
                            $task->save();
                        }
                    }
                }

                Session::set('success', 'Orden de Trabajo actualizada correctamente');
            } else {
                Session::set('error', 'Orden de trabajo no encontrada');
            }

            // header('Location: /admin/work-orders');
            exit;
        } catch (\Throwable $th) {
            Session::set('error', $th->getMessage());
            // header("Location: /admin/work-order/$id/edit");
            exit;
        }
    }

    public function destroy($id, $queryParams)
    {
        $work_order = WorkOrder::find($id);

        if ($work_order) {
            $work_order->delete();

            Session::set('success', 'Orden de Trabajo eliminada correctamente');
        } else
            Session::set('error', 'Orden de trabajo no encontrada');

        header('Location: /admin/work-orders');
        exit;
    }
}
