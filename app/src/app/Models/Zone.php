<?php

namespace App\Models;

class Zone extends BaseModel
{
    public int $contract_id;

    public ?string $name;

    protected static function getTableName(): string
    {
        return 'zones';
    }

    protected static function mapDataToModel($data): Zone
    {
        $zone = new self();
        $zone->id = $data['id'];
        $zone->contract_id = $data['contract_id'];
        $zone->name = $data['name'];
        $zone->created_at = $data['created_at'];
        $zone->updated_at = $data['updated_at'];
        $zone->deleted_at = $data['deleted_at'];

        return $zone;
    }

    // Relationship to elements
    public function elements(): array
    {
        return $this->hasMany(Element::class, 'zone_id');
    }
}
