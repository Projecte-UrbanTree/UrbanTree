<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Session;
use App\Models\WorkOrderBlockTask;

class StatsController
{
	public function index($queryParams)
	{
		$current_contract = Session::get('current_contract');
		$tasks = WorkOrderBlockTask::findAll();
		// WorkOrderBlockTask for the current contract
		$tasks = array_filter($tasks, function ($task) use ($current_contract) {
			return $task->workOrderBlock()->workOrder()->contract_id == $current_contract;
		});
		// WorkOrderBlockTask (X) date (Y) count
		View::render([
			'view' => 'Admin/Stats',
			'title' => 'Estadísticas',
			'layout' => 'Admin/AdminLayout',
			'data' => [
				'tasks' => $tasks,
			],
		]);
	}
}