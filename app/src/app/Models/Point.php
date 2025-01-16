<?php

namespace App\Models;

class Point extends BaseModel
{
    public $latitude;

    public $longitude;

    public ?int $zone_id;

    public ?int $element_id;

    protected static function getTableName(): string
    {
        return 'points';
    }

    protected static function mapDataToModel($data): Point
    {
        $point = new self;
        $point->id = $data['id'];
        $point->latitude = $data['latitude'];
        $point->longitude = $data['longitude'];
        $point->zone_id = $data['zone_id'];
        $point->element_id = $data['element_id'];
        $point->created_at = $data['created_at'];
        $point->updated_at = $data['updated_at'];
        $point->deleted_at = $data['deleted_at'];

        return $point;
    }

    public function zone(): ?Zone
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function element(): ?Element
    {
        return $this->belongsTo(Element::class, 'element_id');
    }
}
