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
        $work_report = new self();
        $work_report->id = $data['id'];
        $work_report->work_order_id = $data['work_order_id'];
        $work_report->observation = $data['observation'];
        $work_report->spent_fuel = $data['spent_fuel'];
        $work_report->created_at = $data['created_at'];
        $work_report->updated_at = $data['updated_at'];
        $work_report->deleted_at = $data['deleted_at'];

        return $work_report;
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
