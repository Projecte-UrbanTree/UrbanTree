<?php

namespace App\Models;

class Zone extends BaseModel
{
    public $name;

    public $postal_code;

    public $point_id;

    // Fetch the zone's point
    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }

    protected static function getTableName()
    {
        return 'zones';
    }

    protected static function mapDataToModel($data)
    {
        $zone = new Zone();
        $zone->id = $data['id'];
        $zone->name = $data['name'];
        $zone->postal_code = $data['postal_code'];
        $zone->point_id = $data['point_id'];
        $zone->created_at = $data['created_at'];

        return $zone;
    }
}
