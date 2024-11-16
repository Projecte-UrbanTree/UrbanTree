<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\View;
use App\Models\WorkReport;

class ZoneController implements BaseController
{
    public function get()
    {
        $work_reports = WorkReport::findAll();
        View::render([
            "view" => "WorkReport",
            "title" => "Work Report",
            "layout" => "MainLayout",
            "data" => ["work_reports" => $work_reports]
        ]);
    }

    public function post() {}
    public function put() {}
    public function delete() {}
}
