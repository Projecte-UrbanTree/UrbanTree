<?php

namespace App\Models;

use App\Core\BaseModel;

class WorkReport extends BaseModel
{
	public string $observation;
	public float $spent_fuel;
	public $picture;
	private $created_at;

	protected static function getTableName()
	{
		return 'work_reports';
	}

	protected static function mapDataToModel($data)
	{
		$workReport = new WorkReport();
		$workReport->id = $data['id'];
		$workReport->observation = $data['observation'];
		$workReport->spent_fuel = $data['spent_fuel'];
		$workReport->picture = $data['picture'];
		$workReport->created_at = $data['created_at'];
		return $workReport;
	}

	// public function workOrder()
	// {
	// 	return $this->belongsTo(WorkOrder::class, 'id', 'id');
	// }

	public function getCreatedAt()
	{
		return $this->created_at;
	}
}
