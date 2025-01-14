<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Session;
use App\Models\WorkOrderBlockTask;
use App\Models\TaskType;
use App\Models\TreeType;

class StatsController
{
	public function index($queryParams)
	{
		$current_contract = Session::get('current_contract');
		$tasks = WorkOrderBlockTask::findAll();
		$taskTypes = TaskType::findAll();
		$treeTypes = TreeType::findAll();
		$tasks = array_filter($tasks, function ($task) use ($current_contract) {
			return $task->workOrderBlock()->workOrder()->contract_id == $current_contract;
		});
		View::render([
			'view' => 'Admin/Stats',
			'title' => 'Estadísticas',
			'layout' => 'Admin/AdminLayout',
			'data' => [
				'tasks' => $tasks,
				'taskTypes' => $taskTypes,
				'treeTypes' => $treeTypes,
			],
		]);
	}
}