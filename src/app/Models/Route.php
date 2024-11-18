<?php

namespace App\Models;

class Route extends BaseModel
{
    public ?float $distance;
    public ?int $point_id;
    public ?int $travel_time;

    protected static function getTableName(): string
    {
        return 'routes';
    }

    protected static function mapDataToModel($data): Route
    {
        $role = new self();
        $role->id = $data['id'];
        $role->distance = $data['distance'];
        $role->point_id = $data['point_id'];
        $role->travel_time = $data['travel_time'];
        $role->created_at = $data['created_at'];

        return $role;
    }

    public function point(): Point
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
}
