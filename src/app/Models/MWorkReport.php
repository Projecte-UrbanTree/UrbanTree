<?php

namespace App\Models;

class MWorkReport extends BaseModel
{
    public ?string $observation;
    public ?float $spent_fuel;
    public ?string $photo;

    protected static function getTableName(): string
    {
        return 'work_reports';
    }

    protected static function mapDataToModel($data): MWorkReport
    {
        $workReport = new self();
        $workReport->id = $data['id'];
        $workReport->observation = $data['observation'];
        $workReport->spent_fuel = $data['spent_fuel'];
        $workReport->photo = $data['photo'];
        $workReport->created_at = $data['created_at'];
        return $workReport;
    }

    public function workOrder(): MWorkOrder
    {
        return $this->belongsTo(MWorkOrder::class, 'id');
    }
}
