<?php

namespace App\Models;

class TreeType extends BaseModel
{
    public string $family;

    public string $genus;

    public string $species;

    protected static function getTableName(): string
    {
        return 'tree_types';
    }

    protected static function mapDataToModel($data): TreeType
    {
        $tree_type = new self();
        $tree_type->id = $data['id'];
        $tree_type->family = $data['family'];
        $tree_type->genus = $data['genus'];
        $tree_type->species = $data['species'];
        $tree_type->created_at = $data['created_at'];

        return $tree_type;
    }
}
