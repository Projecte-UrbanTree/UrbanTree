<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\WorkOrder;

class WorkOrderController
{
    public function index($queryParams)
    {
        $workOrders = WorkOrder::findAll();
        View::render([
            'view' => 'Admin/WorkOrders',
            'title' => 'Manage Orders',
            'layout' => 'AdminLayout',
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
            'layout' => 'AdminLayout',
            'data' => ['workOrders' => $workOrders],
        ]);
    }

    public function store($postData) {}

    public function edit($id, $queryParams)
    {
        $order = WorkOrder::find($id);
        View::render([
            'view' => 'Admin/Order/Edit',
            'title' => 'Edit Order',
            'layout' => 'AdminLayout',
            'data' => ['order' => $order],
        ]);
    }

    public function update($id, $postData)
    {
        $order = WorkOrder::find($id);

        $order->save();

        Session::set('success', 'Order updated successfully');

        header('Location: /admin/orders');
    }

    public function destroy($id, $queryParams)
    {
        $order = WorkOrder::find($id);
        $order->delete();

        Session::set('success', 'Order deleted successfully');

        header('Location: /admin/orders');
    }
}
