<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\MWorkOrder;
class CWorkOrder
{
    public function findAll()
    {
        $orders = MWorkOrder::findAll();
        View::render([
            "view" => "order/index",
            "title" => "Order",
            "layout" => "MainLayout",
            "data" => ["orders" => $orders]
        ]);
    }

    public function find()
    {
        $id = $_GET['id'];
        $order = MWorkOrder::find($id);
        View::render([
            "view" => "order",
            "title" => "Order",
            "layout" => "MainLayout",
            "data" => ["order" => $order]
        ]);
    }

    public function indexCreate()
    {
        $orders = MWorkOrder::findAll();
        View::render([
            "view" => "order/create",
            "title" => "Create Order",
            "layout" => "MainLayout",
            "data" => ["orders" => $orders]
        ]);
    }

    public function save()
    {
        $order = new MWorkOrder();

        $order->save();
    }

    public function delete()
    {
        $id = $_GET['id'];
        $order = MWorkOrder::find($id);
        $order->delete();
    }

    public function update()
    {

    }
}