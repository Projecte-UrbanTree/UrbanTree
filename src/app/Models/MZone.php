<?php

namespace App\Models;

class MZone extends BaseModel
{
    public string $name;
    public int $postal_code;
    public int $point_id;

    protected static function getTableName(): string
    {
        return 'zones';
    }

    protected static function mapDataToModel($data): MZone
    {
        $zone = new self();
        $zone->id = $data['id'];
        $zone->name = $data['name'];
        $zone->postal_code = $data['postal_code'];
        $zone->point_id = $data['point_id'];
        $zone->created_at = $data['created_at'];
        return $zone;
    }

    public function point(): MPoint
    {
        return $this->belongsTo(MPoint::class, 'point_id');
    }
}
