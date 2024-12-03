<?php

namespace App\Models;

class WorkReport extends BaseModel
{
    public int $work_order_id;

    public ?string $observation;

    public ?float $spent_fuel;

    protected static function getTableName(): string
    {
        return 'work_reports';
    }

    protected static function mapDataToModel($data): WorkReport
    {
        $workReport = new self();
        $workReport->id = $data['id'];
        $workReport->work_order_id = $data['work_order_id'];
        $workReport->observation = $data['observation'];
        $workReport->spent_fuel = $data['spent_fuel'];
        $workReport->created_at = $data['created_at'];

        return $workReport;
    }

    public function workOrder(): WorkOrder
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'work_report_photos', 'work_report_id', 'photo_id');
    }
}
