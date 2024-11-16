<?php

namespace App\Models;

use App\Core\BaseModel;

class Element extends BaseModel
{
    public int $zone_id;
    public string $name;
    public float $latitude;
    public float $longitude;
    protected $created_at;

    protected static function getTableName()
    {
        return "elements";
    }

    protected static function mapDataToModel($data)
    {
        $element = new Element();
        $element->id = $data['id'];
        $element->zone_id = $data['zone_id'];
        $element->name = $data['name'];
        $element->latitude = $data['latitude'];
        $element->longitude = $data['longitude'];
        $element->created_at = $data['created_at'];
        return $element;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
