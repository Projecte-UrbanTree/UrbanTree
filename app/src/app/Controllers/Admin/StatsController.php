<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Session;
use App\Models\WorkOrderBlockTask;
use App\Models\WorkReport;

class StatsController
{
	public function index($queryParams)
	{
		$current_contract = Session::get('current_contract');
		$current_date = date('Y-m-d');
		$tasks = WorkOrderBlockTask::findAll();

		$startOfWeek = date('Y-m-d', strtotime('monday this week'));
		$endOfWeek = date('Y-m-d', strtotime('friday this week'));

		$tasks = array_filter($tasks, function ($task) use ($current_contract, $startOfWeek, $endOfWeek) {
			$taskDate = $task->workOrderBlock()->workOrder()->date;
			if ($current_contract == -1) {
				return $taskDate >= $startOfWeek && $taskDate <= $endOfWeek;
			}
			return $task->workOrderBlock()->workOrder()->contract_id == $current_contract && $taskDate >= $startOfWeek && $taskDate <= $endOfWeek;
		});

		$tasksDone = array_filter($tasks, function ($task) {
			return $task->status == 1;
		});

		$tasksNotDone = array_filter($tasks, function ($task) {
			return $task->status == 0;
		});

		$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

		$tasksDoneCount = array_map(function ($day) use ($tasksDone) {
			return count(array_filter($tasksDone, function ($task) use ($day) {
				return date('l', strtotime($task->workOrderBlock()->workOrder()->date)) == $day;
			}));
		}, $days);

		$tasksNotDoneCount = array_map(function ($day) use ($tasksNotDone) {
			return count(array_filter($tasksNotDone, function ($task) use ($day) {
				return date('l', strtotime($task->workOrderBlock()->workOrder()->date)) == $day;
			}));
		}, $days);

		$hoursWorked = array_map(function ($day) use ($tasks) {
			return array_reduce(array_filter($tasks, function ($task) use ($day) {
				return date('l', strtotime($task->workOrderBlock()->workOrder()->date)) == $day;
			}), function ($carry, $task) {
				return $carry + $task->spent_time;
			}, 0);
		}, $days);

		$workReports = WorkReport::findAll();
		$fuelConsumption = array_map(function ($day) use ($workReports, $current_contract) {
			return array_reduce(array_filter($workReports, function ($report) use ($day, $current_contract) {
				if ($current_contract == -1) {
					return date('l', strtotime($report->workOrder()->date)) == $day;
				}
				return date('l', strtotime($report->workOrder()->date)) == $day && $report->workOrder()->contract_id == $current_contract;
			}), function ($carry, $report) {
				return $carry + $report->spent_fuel;
			}, 0);
		}, $days);

		View::render([
			'view' => 'Admin/Stats',
			'title' => 'Estadísticas',
			'layout' => 'Admin/AdminLayout',
			'data' => [
				'tasksDoneCount' => $tasksDoneCount,
				'tasksNotDoneCount' => $tasksNotDoneCount,
				'hoursWorked' => $hoursWorked,
				'fuelConsumption' => $fuelConsumption,
			],
		]);
	}
}