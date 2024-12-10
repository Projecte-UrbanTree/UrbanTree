<?php

namespace App\Models;

class ZonePredefined extends BaseModel
{
    public ?int $zone_id;

    public ?string $name;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'zones_predefined';
    }

    protected static function mapDataToModel($data): ZonePredefined
    {
        $zone_predefined = new self();
        $zone_predefined->id = $data['id'];
        $zone_predefined->zone_id = $data['zone_id'];
        $zone_predefined->name = $data['name'];
        $zone_predefined->photo_id = $data['photo_id'];
        $zone_predefined->created_at = $data['created_at'];
        $zone_predefined->updated_at = $data['updated_at'];
        $zone_predefined->deleted_at = $data['deleted_at'];

        return $zone_predefined;
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
