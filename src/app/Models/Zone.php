<?php

namespace App\Models;

class Zone extends BaseModel
{
    public ?int $point_id;

    protected static function getTableName(): string
    {
        return 'zones';
    }

    protected static function mapDataToModel($data): Zone
    {
        $zone = new self();
        $zone->id = $data['id'];
        $zone->point_id = $data['point_id'];
        $zone->created_at = $data['created_at'];

        return $zone;
    }

    public function point(): ?Point
    {
        if ($this->point_id)
            return $this->belongsTo(Point::class, 'point_id');
    }
}
