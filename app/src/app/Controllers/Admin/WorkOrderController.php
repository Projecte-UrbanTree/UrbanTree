<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;
use App\Models\Task;
use App\Models\TaskType;
use App\Models\Zone;
use App\Models\Contract;
use App\Models\User;


class WorkOrderController
{
    public function index($queryParams)
    {
        $workOrders = WorkOrder::findAll();
        View::render([
            'view' => 'Admin/WorkOrders',
            'title' => 'Manage Orders',
            'layout' => 'Admin/AdminLayout',
            'data' => ['workOrders' => $workOrders],
        ]);
        Session::remove('success');
    }

    public function create($queryParams)
    {
        $workOrders = WorkOrder::findAll();
        View::render([
            'view' => 'Admin/WorkOrder/Create',
            'title' => 'Add Order',
            'layout' => 'Admin/AdminLayout',
            'data' => ['workOrders' => $workOrders],
        ]);
    }

    public function store($postData)
    {

        $workOrders = new WorkOrder();
        $workOrders->contract_id = $postData['contract_id'];
        $workOrders->save();





        Session::set('success', 'Work Order created successfully');

        header('Location: /work-orders');
    }

    public function edit($id, $queryParams)
    {
        $workOrders = WorkOrder::find($id);
        View::render([
            'view' => 'Admin/WorkOrder/Edit',
            'title' => 'Edit Order',
            'layout' => 'Admin/AdminLayout',
            'data' => ['workOrders' => $workOrders],
        ]);
    }

    public function update($id, $postData)
    {
        $workOrders = WorkOrder::find($id);

        $workOrders->save();

        Session::set('success', 'Work Order updated successfully');

        header('Location: /admin/work-orders');
    }

    public function destroy($id, $queryParams)
    {
        $workOrders = WorkOrder::find($id);
        $workOrders->delete();

        Session::set('success', 'Work Order deleted successfully');

        header('Location: /admin/work-orders');
    }
}
