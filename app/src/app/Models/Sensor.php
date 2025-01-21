<?php

namespace App\Models;

class Sensor extends BaseModel
{
    public int $zone_id;

    public ?int $point_id;

    public ?string $model;

    public bool $is_active;

    protected static function getTableName(): string
    {
        return 'sensors';
    }

    protected static function mapDataToModel($data): Sensor
    {
        $sensor = new self;
        $sensor->id = $data['id'];
        $sensor->zone_id = $data['zone_id'];
        $sensor->point_id = $data['point_id'];
        $sensor->model = $data['model'];
        $sensor->is_active = $data['is_active'];
        $sensor->created_at = $data['created_at'];
        $sensor->updated_at = $data['updated_at'];
        $sensor->deleted_at = $data['deleted_at'];

        return $sensor;
    }

    public function zone(): Zone
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function point(): ?Point
    {
        return $this->belongsTo(Point::class, 'point_id');
    }
}
