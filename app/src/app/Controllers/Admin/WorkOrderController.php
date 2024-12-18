<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\TaskType;
use App\Models\Zone;
use App\Models\User;


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
        $task_types = array_map(function ($task_type) {
            return $task_type->name;
        }, TaskType::findAll());
        $users = array_map(function ($user) {
            return $user->name . ' ' . $user->surname;
        }, User::findAll(['role' => 1]));
        $zones = array_map(function ($zone) {
            return $zone->name;
        }, Zone::findAll(['name' => 'not null']));
        View::render([
            'view' => 'Admin/WorkOrder/Create',
            'title' => 'Nueva Orden de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => ['task_types' => $task_types, 'users' => $users, 'zones' => $zones],
        ]);
    }

    public function store($postData)
    {

        $work_order = new WorkOrder();
        $work_order->contract_id = $postData['contract_id'];

        $work_order->save();

        if ($work_order->getId())
            Session::set('success', 'Orden de Trabajo creada correctamente');
        else
            Session::set('error', 'La orden de trabajo no se pudo crear');

        header('Location: /admin/work-orders');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $work_order = WorkOrder::find($id);

        if (!$work_order) {
            Session::set('error', 'Orden de trabajo no encontrada');
            header('Location: /admin/work-orders');
            exit;
        }

        View::render([
            'view' => 'Admin/WorkOrder/Edit',
            'title' => 'Editando Orden de Trabajo',
            'layout' => 'Admin/AdminLayout',
            'data' => ['work_order' => $work_order],
        ]);
    }

    public function update($id, $postData)
    {
        $work_order = WorkOrder::find($id);

        if ($work_order) {

            $work_order->save();

            Session::set('success', 'Orden de Trabajo actualizada correctamente');
        } else
            Session::set('error', 'Orden de trabajo no encontrada');

        header('Location: /admin/work-orders');
        exit;
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
