<?php

namespace App\Models;

class WorkReportResource extends BaseModel
{
    public int $work_report_id;
    public int $type_resources_id;


    protected static function getTableName(): string
    {
        return 'work_report_resources';
    }

    protected static function mapDataToModel($data): WorkReportResource
    {
        $work_report_resource = new WorkReportResource();
        $work_report_resource->id = $data['id'];
        $work_report_resource->work_report_id = $data['work_report_id'];
        $work_report_resource->type_resources_id = $data['type_resources_id'];
        $work_report_resource->created_at = $data['created_at'];
        $work_report_resource->updated_at = $data['updated_at'];
        $work_report_resource->deleted_at = $data['deleted_at'];

        return $work_report_resource;
    }
    public function workReport()
    {
        return $this->belongsTo(WorkReport::class, 'work_report_id');
    }
    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class, 'type_resources_id');
    }
}
