<?php

namespace App\Models;

class Zone extends BaseModel
{
    public int $contract_id;

    public ?string $name;

    public ?string $color;

    public ?string $description;

    protected static function getTableName(): string
    {
        return 'zones';
    }

    protected static function mapDataToModel($data): Zone
    {
        $zone = new self;
        $zone->id = $data['id'];
        $zone->contract_id = $data['contract_id'];
        $zone->name = $data['name'];
        $zone->color = $data['color']; // Map color
        $zone->description = $data['description']; // Map description
        $zone->created_at = $data['created_at'];
        $zone->updated_at = $data['updated_at'];
        $zone->deleted_at = $data['deleted_at'];

        return $zone;
    }

    public function elements(): array
    {
        return $this->hasMany(Element::class, 'zone_id');
    }

    public function points(): array
    {
        return $this->hasMany(Point::class, 'zone_id');
    }
}
