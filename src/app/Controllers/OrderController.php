<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\Order;
class OrderController implements BaseController
{
    public function get()
    {
        $orders = Order::findAll();
        View::render([
            "view" => "order/index",
            "title" => "Order",
            "layout" => "MainLayout",
            "data" => ["orders" => $orders]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}

}   