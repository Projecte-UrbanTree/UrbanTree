<?php

namespace App\Models;

class Sensor extends BaseModel
{
    public int $zone_id;
    public ?string $model;
    public ?string $class;
    public bool $is_active;

    protected static function getTableName(): string
    {
        return "sensors";
    }

    protected static function mapDataToModel($data): Sensor
    {
        $sensor = new self();
        $sensor->zone_id = $data["zone_id"];
        $sensor->model = $data["model"];
        $sensor->class = $data["class"];
        $sensor->is_active = $data["is_active"];
        $sensor->created_at = $data["created_at"];

        return $sensor;
    }

    public function zone(): Zone
    {
        return $this->belongsTo(Zone::class, "zone_id", "id");
    }
}
