<?php

namespace App\Models;

use App\Core\BaseModel;

class MZone extends BaseModel
{
    public $name;
    public $postal_code;
    public $point_id;

    protected static function getTableName()
    {
        return 'zones';
    }

    protected static function mapDataToModel($data)
    {
        $zone = new MZone();
        $zone->id = $data['id'];
        $zone->name = $data['name'];
        $zone->postal_code = $data['postal_code'];
        $zone->point_id = $data['point_id'];
        $zone->created_at = $data['created_at'];
        return $zone;
    }

    // Fetch the zone's point
    public function point()
    {
        return $this->belongsTo(MPoint::class, 'point_id');
    }
}
