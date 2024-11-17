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

use App\Controllers\CHome;
use App\Controllers\CAuth;

return $routes = [
    "/" => CHome::class,
    "/login" => CAuth::class,
];
