<?php

namespace App\Models;

use App\Core\BaseModel;

class Element extends BaseModel
{
    public string $name;
    public int $zone_id;
    public int $point_id;
    protected $created_at;

    protected static function getTableName()
    {
        return "elements";
    }

    protected static function mapDataToModel($data)
    {
        $element = new Element();
        $element->id = $data['id'];
        $element->name = $data['name'];
        $element->zone_id = $data['zone_id'];
        $element->point_id = $data['point_id'];
        $element->created_at = $data['created_at'];
        return $element;
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id');
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
