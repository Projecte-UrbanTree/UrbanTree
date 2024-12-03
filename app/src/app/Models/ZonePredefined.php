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
        $predefined = new self();
        $predefined->id = $data['id'];
        $predefined->zone_id = $data['zone_id'];
        $predefined->name = $data['name'];
        $predefined->photo_id = $data['photo_id'];
        $predefined->created_at = $data['created_at'];

        return $predefined;
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
