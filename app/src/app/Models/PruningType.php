<?php

namespace App\Models;

class PruningType extends BaseModel
{
    public string $name;

    public ?string $description;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'pruning_types';
    }

    protected static function mapDataToModel($data): PruningType
    {
        $pruning_type = new self();
        $pruning_type->id = $data['id'];
        $pruning_type->name = $data['name'];
        $pruning_type->description = $data['description'];
        $pruning_type->photo_id = $data['photo_id'];
        $pruning_type->created_at = $data['created_at'];
        $pruning_type->updated_at = $data['updated_at'];
        $pruning_type->deleted_at = $data['deleted_at'];

        return $pruning_type;
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
