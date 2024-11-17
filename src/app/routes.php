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

use App\Controllers\CHome;
use App\Controllers\CAuth;

return $routes = [
    "GET" => [
        "/" => [
            "controller" => CHome::class,
            "method" => "index"
        ],
        "/login" => [
            "controller" => CAuth::class,
            "method" => "index"
        ]
    ],
];
