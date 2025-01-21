<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\WorkReport;

class WorkReportController
{
    public function view($id, $queryParams)
    {
        $report = WorkReport::find($id);

        View::render([
            'view' => 'Admin/WorkReport/View',
            'title' => 'Work Report Details',
            'layout' => 'Admin/AdminLayout',
            'data' => ['report' => $report],
        ]);
    }
}
