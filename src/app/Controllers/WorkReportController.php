<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\WorkReport;

class WorkReportController
{
    public function index()
    {
        $work_reports = WorkReport::getAll();
        View::render([
            "view" => "WorkReport",
            "title" => "Work Report",
            "layout" => "MainLayout",
            "data" => ["work_reports" => $work_reports]
        ]);
    }
}
