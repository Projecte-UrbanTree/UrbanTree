<?php

/***
 * Web Routes are defined here in this file and are loaded in the Router class
 * All routes are defined in the following format:
 *
 * METHOD => [
 *     "URI" => [
 *        "controller" => "ControllerName",
 *        "method" => "methodName"
 *    ]
 * ]
 *
 **/

use App\Controllers\HomeController;
use App\Controllers\AuthController;

return $routes = [
    "GET" => [
        "/" => [
            "controller" => HomeController::class,
            "method" => "index"
        ],
        "/login" => [
            "controller" => AuthController::class,
            "method" => "index"
        ]
    ],
];
