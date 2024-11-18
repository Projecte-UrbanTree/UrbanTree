<?php

namespace App\Models;

class MPruningType extends BaseModel
{
    public string $name;
    public ?string $description;

    protected static function getTableName()
    {
        return 'pruning_types';
    }

    protected static function mapDataToModel($data)
    {
        $pruning_type = new MPruningType();
        $pruning_type->id = $data['id'];
        $pruning_type->name = $data['name'];
        $pruning_type->description = $data['description'];
        $pruning_type->created_at = $data['created_at'];

        return $pruning_type;
    }
}
