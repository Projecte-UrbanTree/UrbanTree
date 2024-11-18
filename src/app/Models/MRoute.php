<?php

namespace App\Models;

class MRoute extends BaseModel
{
    public ?float $distance;
    public ?int $point_id;
    public ?int $travel_time;

    protected static function getTableName(): string
    {
        return 'routes';
    }

    protected static function mapDataToModel($data): MRoute
    {
        $role = new self();
        $role->id = $data['id'];
        $role->distance = $data['distance'];
        $role->point_id = $data['point_id'];
        $role->travel_time = $data['travel_time'];
        $role->created_at = $data['created_at'];
        return $role;
    }

    public function point(): MPoint
    {
        return $this->belongsTo(MPoint::class, 'point_id');
    }
}
