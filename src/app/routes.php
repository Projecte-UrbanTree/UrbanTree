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
use App\Controllers\TaskTypeController;
return $routes = [
    "/" => HomeController::class,
    "/login" => AuthController::class,
];
