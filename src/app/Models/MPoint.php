<?php

namespace App\Models;

use App\Core\BaseModel;

class MPoint extends BaseModel
{
    public $latitude;
    public $longitude;

    protected static function getTableName()
    {
        return 'points';
    }

    protected static function mapDataToModel($data)
    {
        $point = new MPoint();
        $point->id = $data['id'];
        $point->latitude = $data['latitude'];
        $point->longitude = $data['longitude'];
        $point->created_at = $data['created_at'];
        return $point;
    }
}
