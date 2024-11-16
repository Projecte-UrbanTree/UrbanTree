<?php

namespace App\Core;

interface BaseController
{
    public function get();
    public function post();
    public function put();
    public function delete();
}
