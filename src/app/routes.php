<?php

/***
 * Web Routes are defined here in this file and are loaded in the Router class
 * All routes are defined in the following format:
 *
 * [
 *     "URI" => "ControllerName",
 * ]
 *
 **/

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\OrderController;

return $routes = [
    "/" => HomeController::class,
    "/login" => AuthController::class,
    "/order" => OrderController::class,
    "/order/create" => OrderController::class,
];
