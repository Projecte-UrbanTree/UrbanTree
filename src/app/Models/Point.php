<?php

namespace App\Models;

use App\Core\BaseModel;

class Point extends BaseModel
{
    public $latitude;
    public $longitude;

    protected static function getTableName()
    {
        return 'points';
    }

    protected static function mapDataToModel($data)
    {
        $point = new Point();
        $point->id = $data['id'];
        $point->latitude = $data['latitude'];
        $point->longitude = $data['longitude'];
        return $point;
    }
}
